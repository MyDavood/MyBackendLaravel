<?php namespace Backend\Laravel\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Inertia\Response;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function inertiaDataTable(
        string $component,
        $dataTableClass,
        array $params = [],
        bool $showForm = false,
        string $formComponent = null,
        array $formParams = [],
    ): Response
    {
        $dataTable = new $dataTableClass;
        $inertiaParams = [
            'searchFields' => fn() => $dataTable->searchFields(),
            'dataTable' => fn() => $dataTable,
            ...$params,
        ];

        if ($showForm && $formComponent != null) {
            inertia()->share(['formComponent' => $formComponent]);
            $inertiaParams['form'] = fn() => [
                'show' => $showForm,
                'params' => $formParams,
            ];
        }

        return inertia($component, $inertiaParams);
    }
}