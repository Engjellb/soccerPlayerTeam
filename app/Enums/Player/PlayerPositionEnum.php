<?php

namespace App\Enums\Player;

enum PlayerPositionEnum: string
{
    case DEFENDER = 'defender';
    case MIDFIELDER = 'midfielder';
    case FORWARD = 'forward';
}
