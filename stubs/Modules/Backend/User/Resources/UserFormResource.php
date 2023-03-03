<?php namespace App\Modules\Backend\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserFormResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'isAdmin' => $this->isAdmin,
            'permissions' => $this->permissions ?? new \stdClass(),
        ];
    }
}
