<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $rick = User::where('email', 'rickblaas@gmail.com')->first();

        if (!$rick) {
            User::factory(1)->create([
                'email' => 'rickblaas@gmail.com',
                'password' => Hash::make('lol12345'),
                'name' => 'Rick Blaas',
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
    }
}

