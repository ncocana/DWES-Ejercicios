<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Profile::factory(10)->create();

        // 5 perfiles sin usuario asociado (conceptualmente sería un error de nuestra aplicación).
        // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
        Profile::factory(5)->create([
            'user_id' => null,
        ]);

        // 3 perfiles con un usuario asociado cada uno.
        // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
        Profile::factory(3)->create();

        // 4 perfiles todos ellos vinculados al mismo usuario (otro error de diseño).
        // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
        Profile::factory(5)->create([
            'user_id' => 1,
        ]);

    }
}
