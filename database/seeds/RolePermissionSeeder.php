<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Forget Permission On Cached
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Create User Role
         * - Super Admin
         * - Admin
         * - Building Manager
         * - Help Desk
         * - Viewer
         */
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'PIC']);
        Role::create(['name' => 'Building Manager']);
        Role::create(['name' => 'Help Desk']);
        Role::create(['name' => 'Viewer']);
        Role::create(['name' => 'Director']);
    }
}
