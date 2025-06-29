<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use App\Models\Profile;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the Application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => '1',
        ]);

        Profile::create([
            'nis' => '-',
            'user_id' => $user->id,
        ]);

        if (app()->isProduction()) {
            $this->call([
                ProductionSeeder::class,
            ]);
        } else {
            $this->call([
                DevelopmentSeeder::class,
            ]);
        }
    }
}
