<?php

namespace App\Http\Resources\API\V1\Auth;

use App\Http\Resources\API\V1\ACLs\RoleResource;
use App\Http\Resources\API\V1\Team\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'roles' => RoleResource::collection($this->roles),
            'team' => new TeamResource($this->team)
        ];
    }
}
