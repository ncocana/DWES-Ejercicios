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
        // Usuario determinado.
        User::factory()
            ->create([
                'name' => 'admin',
                'email' => 'ncocana@cifpfbmoll.eu',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

        // 5 usuarios sin perfil asociado.
        // MUST HAVE A RELATION OF "USER BELONGSTO PROFILE - PROFILE HASONE USER"
        // WITH ALL THE CONFIGURATIONS ON MODELS, MIGRATIONS, AND FACTORIES REQUIRED!
        // RELATION REQUIRED: "USER BELONGSTO PROFILE - PROFILE HASONE USER"
        // User::factory(5)->create([
        //     'profile_id' => null,
        // ]);

        // 5  usuarios con un perfil asociado (1:1).
        // MUST HAVE A RELATION OF "USER BELONGSTO PROFILE - PROFILE HASONE USER"
        // WITH ALL THE CONFIGURATIONS ON MODELS, MIGRATIONS, AND FACTORIES REQUIRED!
        // RELATION REQUIRED: "USER BELONGSTO PROFILE - PROFILE HASONE USER"
        // User::factory(5)
        // ->has(Profile::factory(), 'HasOneProfile')
        // ->create();

        // ¿Cómo evitar que un usuario se vincule a más de un perfil?
        // ¿Cómo evitar que un perfil no se vincule a ningún usuario?
        // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
        User::factory(5)
        ->has(Profile::factory(), 'HasOneProfile')
        ->create();
    }
}
