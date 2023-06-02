<?php

namespace Backend\Laravel;

use Backend\Laravel\Http\Controllers\ApiAction;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->mergeConfigFrom(__DIR__.'/../config/backend.php', 'backend');

        Route::macro('apiGet', function ($path) {
            $path = ltrim($path);

            return Route::get("v{v}$/$path", ApiAction::class);
        });

        Route::macro('apiPost', function ($path) {
            $path = ltrim($path);

            return Route::post("v{v}$/$path", ApiAction::class);
        });

        Route::macro('apiPut', function ($path) {
            $path = ltrim($path);

            return Route::put("v{v}$/$path", ApiAction::class);
        });

        Route::macro('apiDelete', function ($path) {
            $path = ltrim($path);

            return Route::delete("v{v}$/$path", ApiAction::class);
        });
    }
}
