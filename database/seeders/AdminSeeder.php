<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role admin jika belum ada
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Buat user admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@connectrip',
            'password' => bcrypt('connectrip000'), // Ganti dengan password yang Anda inginkan
        ]);

        // Assign role admin
        $admin->assignRole('admin');
    }
}
