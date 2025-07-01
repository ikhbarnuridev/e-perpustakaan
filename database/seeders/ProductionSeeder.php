<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin
        $admin = UserFactory::new()->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');

        // Create librarian
        $librarian = UserFactory::new()->create([
            'username' => 'librarian',
            'email' => 'librarian@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $librarian->assignRole('librarian');
    }
}
