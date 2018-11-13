<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\Degree;

class DegreeSeeder extends Seeder
{
  public function run(){

    $degrees= [
      ["degree"=>"Ensino fundamental incompleto","order"=>0],
      ["degree"=>"Ensino fundamental completo","order"=>1],
      ["degree"=>"Ensino médio incompleto","order"=>2],
      ["degree"=>"Ensino médio completo","order"=>3],
      ["degree"=>"Ensino superior Incompleto ","order"=>4],
      ["degree"=>"Ensino superior Completo ","order"=>5],
    ];







    foreach($degrees as $d)
      Degree::create($d);
  }
} 
