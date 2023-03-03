<?php namespace App\Modules\Backend\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isAdmin' => $this->isAdmin,
            'twoFa' => $this->secret != null,
            'created_at_date' => jdate($this->created_at)->format('Y/m/d'),
            'created_at_time' => jdate($this->created_at)->format('H:i'),
            'updated_at_date' => jdate($this->updated_at)->format('Y/m/d'),
            'updated_at_time' => jdate($this->updated_at)->format('H:i'),
        ];
    }
}
