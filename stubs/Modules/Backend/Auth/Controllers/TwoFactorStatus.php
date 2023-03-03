<?php namespace App\Modules\Backend\Auth\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;

class TwoFactorStatus extends BaseController
{
    public function __invoke(): array
    {
        $user = auth()->user();

        return [
            'status' => !empty($user->secret),
        ];
    }
}
