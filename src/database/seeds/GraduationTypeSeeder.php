<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\GraduationType;

class GraduationTypeSeeder extends Seeder
{
  public function run(){

    $graduationTypes= [
      ["title"=>"Graduação", "order"=>0],
      ["title"=>"Pós-Graduação", "order"=>1],
      ["title"=>"Mestrado", "order"=>2],
      ["title"=>"Doutorado", "order"=>3],
    ];
    
    foreach($graduationTypes as $s)
      GraduationType::create($s);
  }
} 
