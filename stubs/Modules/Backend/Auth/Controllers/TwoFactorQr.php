<?php namespace App\Modules\Backend\Auth\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorQr extends BaseController
{
    public function __invoke(Google2FA $google2FA): array
    {
        $user = auth()->user();
        $secretKey = $google2FA->generateSecretKey();

        return [
            'secret' => $secretKey,
            'qrData' => "otpauth://totp/" . config('app.name') . ':' . $user->username . "?secret=" . $secretKey,
        ];
    }
}
