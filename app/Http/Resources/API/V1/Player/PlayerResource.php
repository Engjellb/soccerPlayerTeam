<?php

namespace App\Http\Resources\API\V1\Player;

use App\Http\Resources\API\V1\Player\Skill\PlayerSkillResource;
use App\Http\Resources\API\V1\Team\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'position' => $this->position,
            'playerSkills' => PlayerSkillResource::collection($this->skills),
            'team' => new TeamResource($this->team)
        ];
    }
}
