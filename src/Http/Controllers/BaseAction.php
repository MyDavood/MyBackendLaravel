<?php namespace Backend\Laravel\Http\Controllers;

use Illuminate\Http\Request;

class BaseAction extends BaseController
{
    private int $version;

    public function __construct(Request $request)
    {
        $this->version = intval($request->get('v', 1));
    }
    public function getVersion(): int
    {
        return $this->version;
    }
}
