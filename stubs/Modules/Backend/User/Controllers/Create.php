<?php namespace App\Modules\Backend\User\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use App\Modules\Backend\User\Requests\SaveUserRequest;
use Inertia\Response;

class Create extends BaseController
{
    /**
     * @throws AuthorizationException
     */
    public function show(): Response
    {
        $this->authorize('create', User::class);

        return inertia('backend/users/form', [
            'allPermissions' => config('auth.permissions'),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(SaveUserRequest $request): RedirectResponse
    {
        $this->authorize("create", User::class);

        User::create($request->only([
            'name', 'username', 'password', 'isAdmin', 'permissions'
        ]));

        return redirect('/backend/users');
    }
}
