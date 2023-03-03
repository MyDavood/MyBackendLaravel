<?php namespace App\Modules\Backend\User\Controllers;

use App\Models\User;
use App\Modules\Backend\User\Requests\SaveUserRequest;
use Backend\Laravel\Http\Controllers\BaseController;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use App\Modules\Backend\User\Resources\UserFormResource;

class Edit extends BaseController
{
    /**
     * @throws AuthorizationException
     */
    public function show(User $user): Response
    {
        $this->authorize('view', $user);

        return inertia('backend/users/form', [
            'item' => new UserFormResource($user),
            'allPermissions' => config('auth.permissions'),
            'backTo' => request()->input('backTo', '/backend/users'),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(SaveUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize("update", $user);

        $permissions = $request->permissions;
        if ($request->isAdmin) {
            $permissions = new \stdClass();
        }

        $data = $request->only(['name', 'username']);
        $data['isAdmin'] = $request->isAdmin;
        $data['permissions'] = $permissions;

        if(!empty($request->password)) {
            $data['password'] = $request->password;
        }
        $user->update($data);

        return redirect()->to($request->get('backTo', '/backend/users'));
    }
}
