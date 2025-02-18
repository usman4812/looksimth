<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     Permission::create(['name' => 'manage settings',  'guard_name' => 'superadmin','type' => 1]);
    //     Permission::create(['name' => 'edit settings',  'guard_name' => 'superadmin','type' => 1]);

    //     Permission::create(['name' => 'manage users',  'guard_name' => 'superadmin','type' => 2]);
    //     Permission::create(['name' => 'edit users',  'guard_name' => 'superadmin','type' => 2]);
    //     Permission::create(['name' => 'create users',  'guard_name' => 'superadmin','type' => 2]);
    //     Permission::create(['name' => 'delete users',  'guard_name' => 'superadmin','type' => 2]);

    //     Permission::create(['name' => 'manage roles',  'guard_name' => 'superadmin','type' => 3]);
    //     Permission::create(['name' => 'edit roles',  'guard_name' => 'superadmin','type' => 3]);
    //     Permission::create(['name' => 'create roles',  'guard_name' => 'superadmin','type' => 3]);
    //     Permission::create(['name' => 'delete roles',  'guard_name' => 'superadmin','type' => 3]);

    //     Permission::create(['name' => 'manage drivers',  'guard_name' => 'superadmin','type' => 4]);

    //     Permission::create(['name' => 'manage pages',  'guard_name' => 'superadmin','type' => 5]);
    //     Permission::create(['name' => 'edit pages',  'guard_name' => 'superadmin','type' => 5]);
    //     Permission::create(['name' => 'create pages',  'guard_name' => 'superadmin','type' => 5]);
    //     Permission::create(['name' => 'delete pages',  'guard_name' => 'superadmin','type' => 5]);

    //     Permission::create(['name' => 'manage transactions',  'guard_name' => 'superadmin','type' => 6]);

    //     Permission::create(['name' => 'manage gift cards',  'guard_name' => 'superadmin','type' => 7]);
    //     Permission::create(['name' => 'edit gift cards',  'guard_name' => 'superadmin','type' => 7]);
    //     Permission::create(['name' => 'create gift cards',  'guard_name' => 'superadmin','type' => 7]);
    //     Permission::create(['name' => 'delete gift cards',  'guard_name' => 'superadmin','type' => 7]);

    //     Permission::create(['name' => 'manage discounts',  'guard_name' => 'superadmin','type' => 8]);
    //     Permission::create(['name' => 'edit discounts',  'guard_name' => 'superadmin','type' => 8]);
    //     Permission::create(['name' => 'create discounts',  'guard_name' => 'superadmin','type' => 8]);
    //     Permission::create(['name' => 'delete discounts',  'guard_name' => 'superadmin','type' => 8]);

    //     Permission::create(['name' => 'manage plans',  'guard_name' => 'superadmin','type' => 9]);
    //     Permission::create(['name' => 'edit plans',  'guard_name' => 'superadmin','type' => 9]);
    //     Permission::create(['name' => 'create plans',  'guard_name' => 'superadmin','type' => 9]);
    //     Permission::create(['name' => 'delete plans',  'guard_name' => 'superadmin','type' => 9]);

    //     Permission::create(['name' => 'manage meals',  'guard_name' => 'superadmin','type' => 10]);
    //     Permission::create(['name' => 'edit meals',  'guard_name' => 'superadmin','type' => 10]);
    //     Permission::create(['name' => 'create meals',  'guard_name' => 'superadmin','type' => 10]);
    //     Permission::create(['name' => 'delete meals',  'guard_name' => 'superadmin','type' => 10]);

    //     Permission::create(['name' => 'manage menu',  'guard_name' => 'superadmin','type' => 11]);
    //     Permission::create(['name' => 'edit menu',  'guard_name' => 'superadmin','type' => 11]);
    //     Permission::create(['name' => 'create menu',  'guard_name' => 'superadmin','type' => 11]);
    //     Permission::create(['name' => 'delete menu',  'guard_name' => 'superadmin','type' => 11]);

    //     Permission::create(['name' => 'manage orders',  'guard_name' => 'superadmin','type' => 12]);

    //     Permission::create(['name' => 'manage customers',  'guard_name' => 'superadmin','type' => 13]);
    //     Permission::create(['name' => 'edit customers',  'guard_name' => 'superadmin','type' => 13]);
    //     Permission::create(['name' => 'create customers',  'guard_name' => 'superadmin','type' => 13]);
    //     Permission::create(['name' => 'delete customers',  'guard_name' => 'superadmin','type' => 13]);

    //     Permission::create(['name' => 'manage sms',  'guard_name' => 'superadmin','type' => 14]);
    //     Permission::create(['name' => 'send sms',  'guard_name' => 'superadmin','type' => 14]);
    //     Permission::create(['name' => 'send email',  'guard_name' => 'superadmin','type' => 14]);
    // }

    public function run(): void
{
    $permissions = [
        ['name' => 'home view', 'guard_name' => 'superadmin', 'type' => 1],

        // Users Permissions
        ['name' => 'manage users', 'guard_name' => 'superadmin', 'type' => 2],
        ['name' => 'create users', 'guard_name' => 'superadmin', 'type' => 2],
        ['name' => 'edit users', 'guard_name' => 'superadmin', 'type' => 2],
        ['name' => 'delete users', 'guard_name' => 'superadmin', 'type' => 2],

        // Workers Permissions
        ['name' => 'manage workers', 'guard_name' => 'superadmin', 'type' => 3],
        ['name' => 'create workers', 'guard_name' => 'superadmin', 'type' => 3],
        ['name' => 'edit workers', 'guard_name' => 'superadmin', 'type' => 3],
        ['name' => 'delete workers', 'guard_name' => 'superadmin', 'type' => 3],

        // Categories Permissions
        ['name' => 'manage categories', 'guard_name' => 'superadmin', 'type' => 4],
        ['name' => 'create categories', 'guard_name' => 'superadmin', 'type' => 4],
        ['name' => 'edit categories', 'guard_name' => 'superadmin', 'type' => 4],
        ['name' => 'delete categories', 'guard_name' => 'superadmin', 'type' => 4],

        // Services Permissions
        ['name' => 'manage services', 'guard_name' => 'superadmin', 'type' => 5],
        ['name' => 'create services', 'guard_name' => 'superadmin', 'type' => 5],
        ['name' => 'edit services', 'guard_name' => 'superadmin', 'type' => 5],
        ['name' => 'delete services', 'guard_name' => 'superadmin', 'type' => 5],

        // Bookings Permissions
        ['name' => 'manage bookings', 'guard_name' => 'superadmin', 'type' => 6],
        ['name' => 'create bookings', 'guard_name' => 'superadmin', 'type' => 6],
        ['name' => 'edit bookings', 'guard_name' => 'superadmin', 'type' => 6],
        ['name' => 'delete bookings', 'guard_name' => 'superadmin', 'type' => 6],

        // Jobs Permissions
        ['name' => 'manage jobs', 'guard_name' => 'superadmin', 'type' => 7],
        ['name' => 'create jobs', 'guard_name' => 'superadmin', 'type' => 7],
        ['name' => 'edit jobs', 'guard_name' => 'superadmin', 'type' => 7],
        ['name' => 'delete jobs', 'guard_name' => 'superadmin', 'type' => 7],

        // Finance Permissions
        ['name' => 'manage finance', 'guard_name' => 'superadmin', 'type' => 8],
        ['name' => 'create finance', 'guard_name' => 'superadmin', 'type' => 8],
        ['name' => 'edit finance', 'guard_name' => 'superadmin', 'type' => 8],
        ['name' => 'delete finance', 'guard_name' => 'superadmin', 'type' => 8],

        // Settings Permissions
        ['name' => 'manage settings', 'guard_name' => 'superadmin', 'type' => 9],
        ['name' => 'edit settings', 'guard_name' => 'superadmin', 'type' => 9],
        ['name' => 'update settings', 'guard_name' => 'superadmin', 'type' => 9],

        // Roles Permissions
        ['name' => 'manage roles', 'guard_name' => 'superadmin', 'type' => 10],
        ['name' => 'create roles', 'guard_name' => 'superadmin', 'type' => 10],
        ['name' => 'edit roles', 'guard_name' => 'superadmin', 'type' => 10],
        ['name' => 'delete roles', 'guard_name' => 'superadmin', 'type' => 10],

        // Banners Permissions
        ['name' => 'manage banners', 'guard_name' => 'superadmin', 'type' => 10],
        ['name' => 'create banners', 'guard_name' => 'superadmin', 'type' => 10],
        ['name' => 'edit banners', 'guard_name' => 'superadmin', 'type' => 10],
        ['name' => 'delete banners', 'guard_name' => 'superadmin', 'type' => 10],
    ];

    foreach ($permissions as $permission) {
        Permission::updateOrCreate(
            ['name' => $permission['name'], 'guard_name' => $permission['guard_name']],
            [
                'type' => $permission['type'],
            ]
        );
    }
}

}
