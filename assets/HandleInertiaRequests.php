<?php namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function rootView(Request $request): string
    {
        if ($request->is('backend*')) {
            return 'backend';
        }
        return 'app';
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'isAdmin' => $request->user()->isAdmin,
                        'permissions' => $request->user()->permissions,
                    ] : null,
                ];
            },
        ]);
    }
}
