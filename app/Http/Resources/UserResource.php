<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'         => $this->id,
            'FullName'   => $this->FullName,
            'Email'      => $this->email,
            'IsActive'   => $this->IsActive,
            'CreatedDay' => $this->created_at,
           
            'Roles'      => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}