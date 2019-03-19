<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSetFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('character_set_feature')->insert([
            ['character_set_id' => 1, 'feature_id' => 6],
            ['character_set_id' => 1, 'feature_id' => 7],
            ['character_set_id' => 1, 'feature_id' => 8],
            ['character_set_id' => 1, 'feature_id' => 11],
            ['character_set_id' => 1, 'feature_id' => 1],
            ['character_set_id' => 1, 'feature_id' => 13],
            ['character_set_id' => 1, 'feature_id' => 10],

            ['character_set_id' => 2, 'feature_id' => 1],
            ['character_set_id' => 2, 'feature_id' => 28],
            ['character_set_id' => 2, 'feature_id' => 15],
            ['character_set_id' => 2, 'feature_id' => 16],
            ['character_set_id' => 2, 'feature_id' => 18],
            ['character_set_id' => 2, 'feature_id' => 26],

            ['character_set_id' => 3, 'feature_id' => 5],
            ['character_set_id' => 3, 'feature_id' => 9],
            ['character_set_id' => 3, 'feature_id' => 29],
            ['character_set_id' => 3, 'feature_id' => 17],
            ['character_set_id' => 3, 'feature_id' => 23],
            ['character_set_id' => 3, 'feature_id' => 24],
            ['character_set_id' => 3, 'feature_id' => 25],



            ['character_set_id' => 4, 'feature_id' => 3],
            ['character_set_id' => 4, 'feature_id' => 19],
            ['character_set_id' => 4, 'feature_id' => 10],
            ['character_set_id' => 4, 'feature_id' => 4],
            ['character_set_id' => 4, 'feature_id' => 12],
            ['character_set_id' => 4, 'feature_id' => 14],
            ['character_set_id' => 4, 'feature_id' => 20],
            ['character_set_id' => 4, 'feature_id' => 21],
            ['character_set_id' => 4, 'feature_id' => 23],
            ['character_set_id' => 4, 'feature_id' => 27],
        ]);
    }
}
