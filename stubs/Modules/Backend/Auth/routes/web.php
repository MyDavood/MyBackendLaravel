<?php

use App\Modules\Backend\Auth\Controllers\Login;
use App\Modules\Backend\Auth\Controllers\Logout;
use App\Modules\Backend\Auth\Controllers\TwoFactorQr;
use App\Modules\Backend\Auth\Controllers\TwoFactorRemove;
use App\Modules\Backend\Auth\Controllers\TwoFactorSet;
use App\Modules\Backend\Auth\Controllers\TwoFactorStatus;
use App\Modules\Backend\Auth\Controllers\UpdateProfile;

Route::middleware('guest')->group(function () {
    Route::inertia('login', 'backend/login')->name('login');
    Route::post('login', Login::class);
});

Route::middleware('auth')->group(function () {
    Route::post('auth/logout', Logout::class);
    Route::post('auth/profile', UpdateProfile::class);
   Route::get('auth/2fa/status', TwoFactorStatus::class);
   Route::get('auth/2fa/qr', TwoFactorQr::class);
   Route::put('auth/2fa', TwoFactorRemove::class);
   Route::post('auth/2fa', TwoFactorSet::class);
});
