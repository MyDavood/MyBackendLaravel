<?php namespace App\Modules\Backend\User\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class Delete extends BaseController
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();
    }
}
