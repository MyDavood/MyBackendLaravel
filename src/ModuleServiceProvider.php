<?php

namespace Backend\Laravel;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected array $permissions = [];

    public function addPermissionGroup(array $permissions): void
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $current = config('backend.permissions');
            if ($current == null) {
                $current = [];
            }
            $current[] = $permissions;
            config(['backend.permissions' => $current]);
        }
    }

    public function addApiRoute(string $name, int $version, string $class): void
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $current = config('backend.apis', []);
            $current[$name][$version] = $class;
            config(['backend.apis' => $current]);
        }
    }

    public function addApiRoutes(string $name, array $versions): void
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $current = config('backend.apis', []);
            $current[$name] = $current[$name] + $versions;
            config(['backend.apis' => $current]);
        }
    }
}
