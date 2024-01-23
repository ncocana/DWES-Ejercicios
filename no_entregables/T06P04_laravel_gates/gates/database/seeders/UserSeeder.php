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
                'name' => 'Super',
                'email' => 'ncocana@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'role_name' => "Super",
                'remember_token' => Str::random(10),
            ]);

        User::factory()
            ->create([
                'name' => 'Admin',
                'email' => 'ncocana2@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'role_name' => "Admin",
                'remember_token' => Str::random(10),
            ]);

        User::factory()
            ->create([
                'name' => 'Propietario',
                'email' => 'ncocana3@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'role_name' => "Propietario",
                'remember_token' => Str::random(10),
            ]);

        User::factory()
            ->create([
                'name' => 'Invitado',
                'email' => 'ncocana4@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'role_name' => "Invitado",
                'remember_token' => Str::random(10),
            ]);

        // User::factory(4)
        //     ->create();

    }

}