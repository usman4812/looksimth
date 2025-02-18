<?php

namespace Database\Seeders;

use App\Models\PermissionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [
        ['name' => 'Home', 'guard_name' => 'superadmin'],
        ['name' => 'Users', 'guard_name' => 'superadmin'],
        ['name' => 'Workers', 'guard_name' => 'superadmin'],
        ['name' => 'Categories', 'guard_name' => 'superadmin'],
        ['name' => 'Services', 'guard_name' => 'superadmin'],
        ['name' => 'Bookings', 'guard_name' => 'superadmin'],
        ['name' => 'Jobs', 'guard_name' => 'superadmin'],
        ['name' => 'Finance', 'guard_name' => 'superadmin'],
        ['name' => 'Settings', 'guard_name' => 'superadmin'],
        ['name' => 'Roles', 'guard_name' => 'superadmin'],
        ['name' => 'Banners', 'guard_name' => 'superadmin'],

    ];

    foreach ($data as $item) {
        PermissionType::updateOrCreate(
            ['name' => $item['name']],
            ['guard_name' => $item['guard_name']]
        );
    }
}

}
