<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@tiketidol.com'],
            [
                'name' => 'Admin Tiket Idol',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->call([
            ConcertSeeder::class,
        ]);
    }
}
