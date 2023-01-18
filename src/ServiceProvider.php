<?php namespace Backend\Laravel;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}