<?php namespace Backend\Laravel;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected array $permissions = [];

    public function addPermissionGroup(array $permissions)
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
            $current = config('backend.apis');
            if ($current == null) {
                $current = [];
            }
            $current[$name][$version] = $class;
            config(['backend.apis' => $current]);
        }
    }

    public function addApiRoutes(string $name, array $versions): void
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $current = config("backend.apis.$name", []);
            $current = $current + $versions;
            config(["backend.apis.$name" => $current]);
        }
    }
}
