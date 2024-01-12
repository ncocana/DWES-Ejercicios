<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario predeterminado.
        User::factory()
            ->create([
                'name' => 'ncocana',
                'email' => 'ncocana@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

    }
}
