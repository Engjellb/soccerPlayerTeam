<?php

namespace App\Models\Player;

use App\Models\Skill\Skill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('value', 'player_id')->withTimestamps();
    }
}
