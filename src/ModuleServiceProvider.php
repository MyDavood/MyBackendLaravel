<?php namespace Backend\Laravel;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected array $permissions = [];

    public function addPermissionGroup(array $permissions)
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $current = config('auth.permissions');
            if ($current == null) {
                $current = [];
            }
            $current[] = $permissions;
            config(['auth.permissions' => $current]);
        }
    }
}
