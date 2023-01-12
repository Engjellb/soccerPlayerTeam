<?php

namespace App\Enums\ACLs;

enum Roles: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case PLAYER = 'player';
}
