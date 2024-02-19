<?php

namespace Database\Seeders;

use App\Models\Article;
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
            ->has(Article::factory(2))
            ->create([
                'name' => 'ncocana',
                'email' => 'ncocana@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        
        // Usuario alternativo.
        User::factory()
            ->has(Article::factory(3))
            ->create([
                'name' => 'ncocana2',
                'email' => 'ncocana2@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

    }
}
