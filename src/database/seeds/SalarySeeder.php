<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\Salary;

class SalarySeeder extends Seeder
{
  public function run(){

    $salary= [
      ["salary"=>"Salario Mínimo","order"=>0],
      ["salary"=>"R$ 1.000 a R$ 2.000","order"=>1],
      ["salary"=>"R$ 3.000 a R$ 5.000","order"=>2],
      ["salary"=>"acima R$ 5.000","order"=>3],
      ["salary"=>"acima R$ 10.000","order"=>4],
    ];
    
    foreach($salary as $s)
      Salary::create($s);
  }
} 
