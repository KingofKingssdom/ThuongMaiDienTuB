<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $adminRole = Role::where('name', 'Admin')->first();

        if (!$adminRole) {
            $adminRole = Role::create([
                'name' => 'Admin'
            ]);

   
            $adminUser = User::create([
                'FullName' => 'Administrator',
                'email'    => 'admin@company.com',
                'password' => Hash::make('Admin@123'),
                'IsActive' => true,
            ]);

      
            $adminUser->roles()->attach($adminRole->id);
        }

     
        $userRole = Role::where('name', 'User')->first();

        if (!$userRole) {
            Role::create([
                'name' => 'User'
            ]);
        }
    }
}