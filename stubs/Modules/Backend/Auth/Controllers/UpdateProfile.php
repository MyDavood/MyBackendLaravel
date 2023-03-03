<?php namespace App\Modules\Backend\Auth\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use App\Modules\Backend\Auth\Requests\EditProfileRequest;

class UpdateProfile extends BaseController
{
    public function __invoke(EditProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->only(['name']);
        if (!blank($request->password)) {
            $data['password'] = $request->password;
        }

        $user->update($data);
    }
}
