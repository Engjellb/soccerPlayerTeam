<?php

namespace Database\Seeders\Role;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Player permissions
        $createPlayerPermission = Permission::create(['name' => 'create-player']);
        $showPlayerPermission = Permission::create(['name' => 'show-player']);
        $updatePlayerPermission = Permission::create(['name' => 'update-player']);
        $deletePlayerPermission = Permission::create(['name' => 'delete-player']);

        // Admin permissions
        $createAdminPermission = Permission::create(['name' => 'create-admin']);
        $showAdminPermission = Permission::create(['name' => 'show-admin']);
        $updateAdminPermission = Permission::create(['name' => 'update-admin']);
        $deleteAdminPermission = Permission::create(['name' => 'delete-admin']);

        // Roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $playerRole = Role::create(['name' => 'player']);

        // Grant permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo([$createPlayerPermission, $showPlayerPermission, $updatePlayerPermission,
            $deletePlayerPermission, $showAdminPermission]);
        $playerRole->givePermissionTo($showPlayerPermission);

        $superAdmin = User::create([
            'name' => 'Super admin',
            'email' => 'superAdmin@test.com',
            'password' => 'superAdminTest'
        ]);

        $superAdmin->assignRole($superAdminRole);
    }
}
