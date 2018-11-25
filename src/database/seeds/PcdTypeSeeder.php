<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\PcdType;

class PcdTypeSeeder extends Seeder
{
  public function run(){

    $pcdTypes = [
      ["title"=>"Visual", "order"=>0],
      ["title"=>"Auditivo", "order"=>1],
      ["title"=>"Físico", "order"=>2],
      ["title"=>"Mental", "order"=>3],
      ["title"=>"Múltipla", "order"=>4],
    ];
    
    foreach($pcdTypes as $s)
      PcdType::create($s);
  }
} 
