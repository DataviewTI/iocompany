<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\City;
use Dataview\IOCompany\IOCompanyServiceProvider as SP;

class CitiesSeeder extends Seeder
{
    public function run(){   
      $cities_array = json_decode(file_get_contents(SP::pkgAddr('assets\src\cities.json')), true);
      foreach($cities_array as $c){
          City::create([
              "id"=>$c['i'],
              "city"=>$c['c'],
              "state"=>$c["u"]
          ]);
      }
    }
}
