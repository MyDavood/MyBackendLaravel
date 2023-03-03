<?php namespace App\Modules\Backend\Home;

use Backend\Laravel\ModuleServiceProvider;
use Route;

class ServiceProvider extends ModuleServiceProvider
{
    public function boot(): void {
        Route::middleware(['web', 'auth'])->prefix('backend')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
    }
}
