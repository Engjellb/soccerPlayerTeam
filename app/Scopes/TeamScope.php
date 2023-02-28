<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TeamScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $authUserTeamId = auth()->user()->team_id ?? null; // It is the super admin session if it is null

        if ($authUserTeamId !== null) {
            $builder->where('team_id', $authUserTeamId)->with('team');
        }
    }
}
