<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_superAdmin = Role::create(['name'=>'Super Admin']);
        $role_admin = Role::create(['name' => 'admin']);
        $role_standard = Role::create(['name' => 'user']);

        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'manage logs']);

    }
}
