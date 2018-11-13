<?php
namespace Dataview\IOCompany;
ini_set('memory_limit','1G');

use Illuminate\Database\Seeder;
use Dataview\IOCompany\CNAE;

use Dataview\IOCompany\IOCompanyServiceProvider as SP;

class CNAESeeder extends Seeder
{
  public function run(){  
    $array = json_decode(file_get_contents(SP::pkgAddr('assets\src\cnae\cnae_simplificado.json')), true);
    foreach($array as $c){
        CNAE::create([
          "id"=>$c['id'],
          "description"=>$c['cnae'],
        ]);
    }
    }
}
