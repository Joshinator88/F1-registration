<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Race;
use App\Models\RaceResult;
use App\Models\User;
use App\Models\Profile;
use Database\Factories\RaceFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $users = User::factory(15)->create();

         foreach($users as $user) {
            Profile::create([
                'user_id' => $user->id
            ]);
         }
    }
}
