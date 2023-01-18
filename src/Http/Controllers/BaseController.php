<?php namespace Backend\Laravel\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function inertiaDataTable($component, $dataTableClass, array $params = [])
    {
        $dataTable = new $dataTableClass;

        return inertia($component, [
            'searchFields' => fn() => $dataTable->searchFields(),
            'dataTable' => fn() => $dataTable,
            ...$params,
        ]);
    }
}