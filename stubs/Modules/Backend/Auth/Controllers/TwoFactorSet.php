<?php namespace App\Modules\Backend\Auth\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use Crypt;
use Illuminate\Validation\ValidationException;
use App\Modules\Backend\Auth\Requests\SetTwoFactorRequest;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorSet extends BaseController
{
    public function __invoke(SetTwoFactorRequest $request, Google2FA $google2FA)
    {
        $user = auth()->user();
        if (!empty($user->secret)) {
            abort(404);
        }

        try {
            if ($google2FA->verifyKey($request->secret, $request->password)) {
                $user->secret = Crypt::encryptString($request->secret);
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
