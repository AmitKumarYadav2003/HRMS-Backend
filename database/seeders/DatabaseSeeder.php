<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
    ['email' => 'admin@hrms.com'],
    [
        'name' => 'Admin User',
        'password' => \Hash::make('admin123'),
        'role' => 'admin',
        'department' => 'Admin',
        'designation' => 'Administrator',
    ]
);

// Employee user bhi add kar
User::updateOrCreate(
    ['email' => 'amit01@gmail.com'],
    [
        'name' => 'Amit Yadav',
        'password' => \Hash::make('amit1234'),
        'role' => 'employee',
        'department' => 'IT',
        'designation' => 'Software Developer',
    ]
);

    }
}
