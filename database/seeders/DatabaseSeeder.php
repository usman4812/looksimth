<?php

namespace Database\Seeders;

use App\Models\EhMealCustomerGroup;
use App\Models\Superadmin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\AddPermissionsToAdmin;
use Database\Seeders\CreditCardTypeSeeder;
use Database\Seeders\CustomerGroupseeder;
use Database\Seeders\DietSeeder;
use Database\Seeders\DiscountTypeSeeder;
use Database\Seeders\EhMealStatusSeeder;
use Database\Seeders\IngredientIconSeeder;
use Database\Seeders\IngredientSeeder;
use Database\Seeders\MealSizeSeeder;
use Database\Seeders\MealTypeSeeder;
use Database\Seeders\MealTypesImageSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\PermissionTypesSeeder;
use Database\Seeders\PlanTypeSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\SourceSeeder;
use Database\Seeders\VendorSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = Superadmin::updateOrCreate(
            ["email" => "admin@gmail.com"],
            [
                "uuid" => generate_uuid_key(),
                "name" => "admin",
                "password" => Hash::make('12345678'),
                "status" => 1,
                "avatar" => "blank.png",
            ]
        );

        $rolee = Role::updateOrCreate(
            ["name" => "Admin", "guard_name" => "superadmin"],
            ["name" => "Admin", "guard_name" => "superadmin"]
        );

        $fetchRole = Role::where('id', $rolee->id)->first();
        $admin->assignRole($fetchRole);

        $rolee2 = Role::updateOrCreate(
            ["name" => "Manager", "guard_name" => "superadmin"],
            ["name" => "Manager", "guard_name" => "superadmin"]
        );

        $rolee3 = Role::updateOrCreate(
            ["name" => "User", "guard_name" => "web"],
            ["name" => "User", "guard_name" => "web"]
        );
        $rolee4 = Role::updateOrCreate(
            ["name" => "Worker", "guard_name" => "web"],
            ["name" => "Worker", "guard_name" => "web"]
        );
        $this->call(PermissionTypesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(AddPermissionsToAdmin::class);  
    }
}
