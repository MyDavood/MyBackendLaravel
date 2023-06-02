<?php

namespace Backend\Laravel\Http\Controllers;

use Illuminate\Http\Request;

class ApiAction
{
    public function __invoke(Request $request)
    {
        $versions = config('backend.apis')[$request->route()->getName()];
        $controller = null;
        $version = $request->route()->parameter('v');

        if (is_array($versions)) {
            ksort($versions);

            foreach ($versions as $v => $c) {
                if ($version >= $v) {
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
        $parameters = $request->route()->parameters();
        array_shift($parameters);

        return app()->call($controller, $parameters);
    }
}
