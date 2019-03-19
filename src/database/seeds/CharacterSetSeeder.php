<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('character_sets')->insert([
            ['id' => 1, 'title' => 'Dirigente', 'slug' => 'dirigente'],
            ['id' => 2, 'title' => 'Negociador', 'slug' => 'negociador'],
            ['id' => 3, 'title' => 'Conciliador', 'slug' => 'conciliador'],
            ['id' => 4, 'title' => 'Ponderado', 'slug' => 'ponderado'],
        ]);
    }
}
