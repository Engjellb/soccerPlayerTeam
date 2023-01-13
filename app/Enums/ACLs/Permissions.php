<?php

namespace App\Enums\ACLs;

enum Permissions: string
{
    case CREATE_ADMIN = 'create-admin';
    case SHOW_ADMIN = 'show-admin';
    case UPDATE_ADMIN = 'update-admin';
    case DELETE_ADMIN = 'delete-admin';

    case CREATE_PLAYER = 'create-player';
    case SHOW_PLAYER = 'show-player';
    case UPDATE_PLAYER = 'update-player';
    case DELETE_PLAYER = 'delete-player';
}
