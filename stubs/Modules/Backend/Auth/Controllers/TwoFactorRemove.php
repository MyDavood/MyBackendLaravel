<?php namespace App\Modules\Backend\Auth\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use Crypt;
use Illuminate\Validation\ValidationException;
use App\Modules\Backend\Auth\Requests\RemoveTwoFactorRequest;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorRemove extends BaseController
{
    public function __invoke(RemoveTwoFactorRequest $request, Google2FA $google2FA)
    {
        $user = auth()->user();
        if (empty($user->secret)) {
            abort(404);
        }

        try {
            if ($google2FA->verifyKey(Crypt::decryptString($user->secret), $request->password)) {
                $user->secret = null;
                $user->save();
            } else {
                throw ValidationException::withMessages([
                    'password' => "رمز یکبار مصرف وارد شده معتبر نمی باشد.",
                ]);
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'password' => "رمز یکبار مصرف وارد شده معتبر نمی باشد.",
            ]);
        }
    }
}
