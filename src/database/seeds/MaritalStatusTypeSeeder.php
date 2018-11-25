<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\MaritalStatusType;

class MaritalStatusTypeSeeder extends Seeder
{
  public function run(){

    $maritalStatus = [
      ["title"=>"Solteiro", "order"=>0],
      ["title"=>"Casado", "order"=>1],
      ["title"=>"União Estável", "order"=>2],
      ["title"=>"Divorciado", "order"=>3],
      ["title"=>"Viúvo", "order"=>4],
    ];
    
    foreach($maritalStatus as $s)
      MaritalStatusType::create($s);
  }
} 
