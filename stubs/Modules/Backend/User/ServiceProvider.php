<?php namespace App\Modules\Backend\User;

use App\Models\User;
use Backend\Laravel\ModuleServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Modules\Backend\User\Policies\UserPolicy;
use Route;

class ServiceProvider extends ModuleServiceProvider
{
    public function boot(): void
    {
        Route::middleware(['web', 'auth'])->prefix('backend/users')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });

        Gate::policy(User::class, UserPolicy::class);

        $this->addPermissionGroup([
            "value" => "users",
            "title" => "مدیریت کاربران",
            "children" => [
                [
                    "value" => "viewAny",
                    "title" => "مشاهده لیست کاربران",
                ],
                [
                    "value" => "create",
                    "title" => "درج کاربر جدید",
                    "depend" => "viewAny",
                ],
                [
                    "value" => "update",
                    "title" => "ویرایش کاربر",
                    "depend" => "viewAny",
                ],
                [
                    "value" => "delete",
                    "title" => "حذف کاربر",
                    "depend" => "viewAny",
                ],
            ],
        ]);
    }
}
