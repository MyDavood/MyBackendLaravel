<?php

namespace Backend\Laravel\Http\Controllers;

use Illuminate\Http\Request;

class ApiAction
{
    private int $version;

    public function __construct(Request $request)
    {
        $this->version = intval($request->get('v', 1));
    }

    public function __invoke(Request $request)
    {
        $versions = config('backend.apis.' . $request->route()->getName());
        $controller = null;

        if (is_array($versions)) {
            ksort($versions);

            foreach ($versions as $v => $c) {
                if ($this->version >= $v) {
                    $controller = $c;
                }
            }
        } else {
            $controller = $versions;
        }

        if ($controller == null) {
            abort(404);
        }
        $controller = app()->make($controller);

        return app()->call($controller, $request->route()->parameters());
    }
}