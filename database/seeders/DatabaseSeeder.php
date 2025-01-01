<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $this->call([
            // AdminSeeder::class,
            UserSeeder::class,
            TripSubmissionSeeder::class,
            TripRegistrationSeeder::class,
            PhotoMemoriesSeeder::class,
        ]);
    }
}
