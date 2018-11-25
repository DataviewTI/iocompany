<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\ResignationReason;

class ResignationReasonSeeder extends Seeder
{
  public function run(){

    $salary= [
      ["title"=>"Sem justa causa", "order"=>0],
      ["title"=>"Justa causa", "order"=>1],
      ["title"=>"A pedido", "order"=>2],
    ];
    
    foreach($salary as $s)
    ResignationReason::create($s);
  }
} 
