<?php namespace Backend\Laravel;

use Backend\Laravel\Http\Controllers\ApiAction;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->publishes([
            __DIR__ . '/../stubs/js' => resource_path('js'),
            __DIR__ . '/../stubs/lang/fa' => resource_path('lang/fa'),
            __DIR__ . '/../stubs/lang/fa.json' => resource_path('lang/fa.json'),
            __DIR__ . '/../stubs/scss' => resource_path('scss'),
            __DIR__ . '/../stubs/HandleInertiaRequests.php' => app_path('Http/Middleware/HandleInertiaRequests.php'),
            __DIR__ . '/../stubs/views/app.blade.php' => resource_path('views/app.blade.php'),
            __DIR__ . '/../stubs/views/backend.blade.php' => resource_path('views/backend.blade.php'),
            __DIR__ . '/../stubs/.editorconfig' => base_path('.editorconfig'),
            __DIR__ . '/../stubs/vite.config.js' => base_path('vite.config.js'),
            __DIR__ . '/../stubs/postcss.config.js' => base_path('postcss.config.js'),
            __DIR__ . '/../stubs/package.json' => base_path('package.json'),
            __DIR__ . '/../stubs/Modules' => app_path('Modules'),
        ], 'assets');

        $this->mergeConfigFrom(__DIR__.'/../config/backend.php', 'backend');

        Route::macro('apiGet', function ($path) {
            return Route::get($path, ApiAction::class);
        });

        Route::macro('apiPost', function ($path) {
            return Route::post($path, ApiAction::class);
        });
    }
}