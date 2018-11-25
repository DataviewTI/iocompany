<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\JobDuration;

class JobDurationSeeder extends Seeder
{
  public function run(){

    $jobDurations = [
      ["title"=>"Até 1 ano", "order"=>0],
      ["title"=>"De 1 a 2 anos", "order"=>1],
      ["title"=>"De 2 a 5 anos", "order"=>2],
      ["title"=>"De 6 a 10 anos", "order"=>3],
      ["title"=>"Mais de 11 anos", "order"=>4],
    ];
    
    foreach($jobDurations as $s)
      JobDuration::create($s);
  }
} 
