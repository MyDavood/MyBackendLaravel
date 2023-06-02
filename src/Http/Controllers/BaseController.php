<?php

namespace Backend\Laravel\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function inertiaDataTable(
        string $component,
        $dataTableClass,
        array $params = [],
        string $formComponent = null,
        array $formParams = [],
    ): Response {
        $dataTable = new $dataTableClass;
        $inertiaParams = [
            'searchFields' => fn () => $dataTable->searchFields(),
            'dataTable' => fn () => $dataTable,
            ...$params,
        ];

        if ($formComponent != null) {
            $inertiaParams['form'] = fn () => [
                'show' => $formComponent != null,
                'component' => $formComponent,
                'params' => $formParams,
            ];
        }

        return inertia($component, $inertiaParams);
    }

    public function getBackTo(): ?string
    {
        return request()->input('backTo');
    }

    public function redirectTo(string $path): RedirectResponse
    {
        return redirect()->to($this->getBackTo() ?? $path);
    }

    public function throwValidationException(string $key, string $message)
    {
        throw ValidationException::withMessages([
            $key => $message,
        ]);
    }
}
