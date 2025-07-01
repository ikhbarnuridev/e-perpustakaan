<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
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

        // Create members
        $startNis = 1930511000;

        for ($i = 0; $i < 15; $i++) {
            $nis = $startNis + $i;

            $member = UserFactory::new()->create([
                'username' => (string) $nis,             // atau bisa diganti "member{$i}" jika ingin pakai teks
                'nis' => (string) $nis,
                'email' => "member{$i}@gmail.com",
                'password' => Hash::make('password'),
            ]);

            $member->assignRole('member');
        }
    }
}
