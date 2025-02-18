<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionsToAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::where('guard_name', 'superadmin')->pluck('name');
        $role = Role::where('name', 'Admin')->first();
        
        $role->syncPermissions($permissions);
    }
}
