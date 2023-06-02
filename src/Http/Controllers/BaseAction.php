<?php

namespace Backend\Laravel\Http\Controllers;

use Illuminate\Http\Request;

class BaseAction extends BaseController
{
    public readonly int $version;

    public function __construct(Request $request)
    {
        $this->version = $request->route()->parameter('v');
    }
}
