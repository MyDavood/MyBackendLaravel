<?php namespace App\Modules\Backend\User\Policies;

use App\Models\User;
use Backend\Laravel\Policies\BasePolicy;

class UserPolicy
{
    use BasePolicy;

    protected string $group = "users";

    public function viewAny(User $user): bool
    {
        return $this->can($user, "viewAny");
    }

    public function view(User $user, User $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->can($user, "create");
    }

    public function update(User $user, User $model): bool
    {
        return $this->viewAny($user) && $this->can($user, "update");
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->id != $model->id) {
            return $this->can($user, "viewAny") && $this->can($user, "delete");
        }
        return false;
    }
}
