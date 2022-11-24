<?php

namespace App\Http\Resources\API\V1\Player\Skill;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSkillResource extends JsonResource
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
            'skill' => $this->name,
            'value' => (double)$this->pivot->value,
            'playerId' => $this->pivot->player_id
        ];
    }
}
