<?php

namespace App\Models\Player;

use App\Models\Skill\Skill;
use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'position'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class)
            ->whereNull('player_skill.deleted_at')
            ->withPivot('id', 'value', 'player_id')
            ->withTimestamps();
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
