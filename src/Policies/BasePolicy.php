<?php namespace Backend\Laravel\Policies;

use App\Models\User;

trait BasePolicy
{
    public function before(User $user, $ability) {
        if ($user->isAdmin) {
            return true;
        }
    }

    public function can(User $user, $permission, $group = null) {
        return $user->hasPermission($group ?? $this->group, $permission);
    }
}
