<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $rick = User::where('email', 'rickblaas@live.nl')->first();

        if (!$rick) {
            User::factory(1)->create([
                'email' => 'rickblaas@live.nl',
                'password' => Hash::make('Password'),
                'name' => 'Rick Blaas',
                'admin' => false
            ]);
        }
        $joshua = User::where('email', 'joshua@hotmail.com')->first();

        if (!$joshua) {
            User::factory(1)->create([
                'email' => 'joshua@hotmail.com',
                'password' => Hash::make('Password'),
                'name' => 'Joshua de Bruijn',
                'admin' => false
            ]);
        }

        $admin = User::where('email', 'admin@admin.com')->first();

        if (!$admin) {
            User::factory(1)->create([
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'name' => 'admin',
                'admin' => true
            ]);
        }
        if (User::count() <= 22) {
            User::factory(22)->create();
        }
    }
}

