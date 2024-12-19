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
                'name' => 'Team 1',
                'logo_link' => 'logos/irgl.jpg',
                'leader_user_id' => 1
            ],
            [
                'name' => 'Team 2',
                'logo_link' => 'logos/bharatika.jpg',
                'leader_user_id' => 2
            ],
            [
                'name' => 'Team 3',
                'logo_link' => 'logos/epiclair.jpg',
                'leader_user_id' => 3
            ],
            [
                'name' => 'Team 4',
                'logo_link' => 'logos/irgl.jpg',
                'leader_user_id' => 4
            ],
            [
                'name' => 'Team 5',
                'logo_link' => 'logos/bharatika.jpg',
                'leader_user_id' => 5
            ],
            [
                'name' => 'Team 6',
                'logo_link' => 'logos/epiclair.jpg',
                'leader_user_id' => 6
            ],
            [
                'name' => 'Team 7',
                'logo_link' => 'logos/irgl.jpg',
                'leader_user_id' => 7
            ],
            [
                'name' => 'Team 8',
                'logo_link' => 'logos/bharatika.jpg',
                'leader_user_id' => 8
            ],
            [
                'name' => 'Team 9',
                'logo_link' => 'logos/epiclair.jpg',
                'leader_user_id' => 9
            ],
            [
                'name' => 'Team 10',
                'logo_link' => 'logos/irgl.jpg',
                'leader_user_id' => 10
            ],
            [
                'name' => 'Team 11',
                'logo_link' => 'logos/bharatika.jpg',
                'leader_user_id' => 11
            ],
            [
                'name' => 'Team 12',
                'logo_link' => 'logos/epiclair.jpg',
                'leader_user_id' => 12
            ],
            [
                'name' => 'Team 13',
                'logo_link' => 'logos/irgl.jpg',
                'leader_user_id' => 13
            ],
            [
                'name' => 'Team 14',
                'logo_link' => 'logos/bharatika.jpg',
                'leader_user_id' => 14
            ],
            [
                'name' => 'Team 15',
                'logo_link' => 'logos/epiclair.jpg',
                'leader_user_id' => 15
            ],
        ]);
    }
}
