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
         * Create Role 
         * - Super Admin
         * - Admin 
         */
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'PIC']);
    }
}
