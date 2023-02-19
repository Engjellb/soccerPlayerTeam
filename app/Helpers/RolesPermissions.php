<?php

namespace App\Helpers;

use App\Enums\ACLs\Roles;
use Spatie\Permission\Models\Role;

class RolesPermissions
{
    public function getRole(string $name): Role
    {
        if ($name == Roles::SUPER_ADMIN->value) {
            return Role::findByName('super-admin', 'web');

        } elseif ($name == Roles::ADMIN->value) {
            return Role::findByName('admin', 'web');

        } else {
            return Role::findByName('player', 'web');
        }
    }
}
