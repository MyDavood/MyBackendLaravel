<?php namespace Backend\Laravel;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->publishes([
            __DIR__.'/../assets/fonts' => public_path('fonts'),
            __DIR__.'/../assets/js' => resource_path('js'),
            __DIR__.'/../assets/lang' => resource_path('lang'),
            __DIR__.'/../assets/scss' => resource_path('scss'),
            __DIR__.'/../assets/HandleInertiaRequests.php' => app_path('Http/Middleware/HandleInertiaRequests.php'),
            __DIR__.'/../assets/views/app.blade.php' => resource_path('views/app.blade.php'),
            __DIR__.'/../assets/views/backend.blade.php' => resource_path('views/backend.blade.php'),
            __DIR__.'/../assets/.editorconfig' => base_path('.editorconfig'),
            __DIR__.'/../assets/webpack.config.js' => base_path('webpack.config.js'),
            __DIR__.'/../assets/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/../assets/package.json' => base_path('package.json'),
        ], 'assets');
    }
}