<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'admin@noticepajak.com',
            ],
            [
                'name' => 'Administrator',
                'password' => 'Admin12345',
                'role' => 'admin',
            ]
        );
    }
}