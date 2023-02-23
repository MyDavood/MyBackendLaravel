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

        if ($showForm != null) {
            inertia()->share(['formComponent' => $formComponent]);
        }

        return inertia($component, [
            'searchFields' => fn() => $dataTable->searchFields(),
            'dataTable' => fn() => $dataTable,
            'form' => fn() => [
                'show' => $showForm,
                'params' => $formParams,
            ],
            ...$params,
        ]);
    }
}