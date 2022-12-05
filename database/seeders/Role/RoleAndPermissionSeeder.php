<?php

namespace Database\Seeders\Role;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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

        Permission::create(['name' => 'create-player']);
        Permission::create(['name' => 'show-player']);
        Permission::create(['name' => 'update-player']);
        Permission::create(['name' => 'delete-player']);


        $adminRole = Role::create(['name' => 'admin']);
        $playerRole = Role::create(['name' => 'player']); 

        $adminRole->givePermissionTo(Permission::all());
        $playerRole->givePermissionTo('show-player');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('testTest')
        ]);

        $user->assignRole($adminRole);
    }
}
