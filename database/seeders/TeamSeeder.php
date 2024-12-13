<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            [
                'name' => 'IRGL 2024',
                'logo_link' => 'storage/app/public/uploads/irgl.jpg',
                'leader_user_id' => 1
            ],
            [
                'name' => 'Bharatika 2024',
                'logo_link' => 'storage/app/public/uploads/bharatika.jpg',
                'leader_user_id' => 6
            ],
            [
                'name' => 'Epiclair 2024',
                'logo_link' => 'storage/app/public/uploads/epiclair.jpg',
                'leader_user_id' => 11
            ],            
        ]);
    }
}
