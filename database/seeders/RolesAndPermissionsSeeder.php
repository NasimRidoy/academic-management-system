<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'manage departments']);
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'manage instructors']);
        Permission::create(['name' => 'view enrollments']);

        // Create roles and assign created permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'instructor']);
        $role->givePermissionTo(['manage courses', 'view enrollments']);

        $role = Role::create(['name' => 'student']);
        $role->givePermissionTo(['view enrollments']);

    }
}
