<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::create([
             'name' => 'Hayk',
             'email' => 'admin@admin.com',
             'password' => Hash::make('12Admin21'),
             'email_verified_at' => now()
         ]);
    }
}
