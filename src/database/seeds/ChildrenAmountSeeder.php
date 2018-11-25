<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\ChildrenAmount;

class ChildrenAmountSeeder extends Seeder
{
  public function run(){

    $childrenAmount= [
      ["title"=>"Nenhum", "order"=>0],
      ["title"=>"1 filho", "order"=>1],
      ["title"=>"2 filhos", "order"=>2],
      ["title"=>"3 filhos", "order"=>3],
      ["title"=>"4 filhos", "order"=>4],
      ["title"=>"Mais de 4 filhos", "order"=>5],
    ];
    
    foreach($childrenAmount as $s)
      ChildrenAmount::create($s);
  }
} 
