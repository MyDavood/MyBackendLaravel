<?php namespace App\Modules\Backend\Auth;

use Backend\Laravel\ModuleServiceProvider;
use Route;

class AuthServiceProvider extends ModuleServiceProvider
{
    public function boot(): void {
        Route::middleware('web')->prefix('backend')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
    }
}
