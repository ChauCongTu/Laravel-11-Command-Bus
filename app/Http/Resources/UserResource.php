<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'role' => [
                'roleCode' => $this->role->id,
                'roleName' => $this->role->role_name,
            ],
            'prefecture' => $this->address[0]->prefecture,
            'city' => $this->address[0]->city,
            'address' => $this->address[0]->address,
            'etcAddress' => $this->address[0]->etc_address,
        ];
    }
}
