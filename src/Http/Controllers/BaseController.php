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
        string $formComponent = null,
        mixed $formItem = null,
    ): Response
    {
        $dataTable = new $dataTableClass;

        if ($formComponent != null) {
            inertia()->share(['formComponent' => $formComponent]);
        }

        return inertia($component, [
            'searchFields' => fn() => $dataTable->searchFields(),
            'dataTable' => fn() => $dataTable,
            'form' => fn() => $formComponent != null,
            'formItem' => fn() => $formItem,
            ...$params,
        ]);
    }
}