<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => 'johndoe@gmail.com',
                'display_name' => 'John Doe',
                'password_hash' => Hash::make('user'),
                'global_role' => 'admin'
            ],
            [
                'email' => 'annabella@gmail.com',
                'display_name' => 'Anna Bella',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'bryanlim@gmail.com',
                'display_name' => 'Bryan Lim',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'cornelia@gmail.com',
                'display_name' => 'Cornelia',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'denise@gmail.com',
                'display_name' => 'Denise',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'alexandramcqueen@gmail.com',
                'display_name' => 'Alexandra Mcqueen',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'farrelwijaya@gmail.com',
                'display_name' => 'Farrel Wijaya',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'georginahalim@gmail.com',
                'display_name' => 'Georgina Halim',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'herman@gmail.com',
                'display_name' => 'Herman',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'ivankusuma@gmail.com',
                'display_name' => 'Ivan Kusuma',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'janice@gmail.com',
                'display_name' => 'Janice',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'jeangunawan@gmail.com',
                'display_name' => 'Jean Gunawan',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'karinehartono@gmail.com',
                'display_name' => 'Karine Hartono',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'timothyreynald@gmail.com',
                'display_name' => 'Timothy Reynald',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ],
            [
                'email' => 'levinaw@gmail.com',
                'display_name' => 'Levina W',
                'password_hash' => Hash::make('user'),
                'global_role' => 'user'
            ]
        ]);
    }
}
