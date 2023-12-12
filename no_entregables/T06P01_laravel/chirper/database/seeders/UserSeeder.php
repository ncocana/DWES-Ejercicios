<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        User::factory()
            ->create([
                'name' => 'Noa',
                'lastname' => 'Cocaña',
                'email' => 'ncocana@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

        User::factory(4)
            ->create();

    }

}