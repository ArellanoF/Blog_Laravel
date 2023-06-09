<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'Francesc Arellano',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrator');

        User::create([
            'full_name' => 'Toni mendez',
            'email' => 'author@test.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Author');

        User::factory(10)->create();
    }
}
