<?php

use Illuminate\Database\Seeder;
use App\City;


class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities_array = json_decode(file_get_contents(resource_path("base/js/data/cities.json")), true);
        foreach($cities_array as $c){
            City::create([
                "id"=>$c['i'],
                "city"=>$c['c'],
                "uf"=>$c["u"]
           ]);
        }
    }
}
