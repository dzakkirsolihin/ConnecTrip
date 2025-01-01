<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@connectrip',
            'password' => Hash::make('connectrip000'),
        ]);
        $admin->assignRole('admin');

        // Create regular users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'test1@example',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'test2@example',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'test3@example',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            $user->assignRole('user');
        }
    }
}
