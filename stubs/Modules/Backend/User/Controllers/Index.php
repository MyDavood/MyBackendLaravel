<?php namespace App\Modules\Backend\User\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Response;
use App\Modules\Backend\User\Resources\UserDataTable;

class Index extends BaseController
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize("viewAny", User::class);

        return $this->inertiaDataTable(
            component: 'backend/users/index',
            dataTableClass: UserDataTable::class,
        );
    }

}
