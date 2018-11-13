<?php
namespace Dataview\IOCompany;
ini_set('memory_limit','1G');

use Illuminate\Database\Seeder;
use Dataview\IOCompany\CBOBigGroup;
use Dataview\IOCompany\CBOMainSubgroup;
use Dataview\IOCompany\CBOSubgroup;
use Dataview\IOCompany\CBOFamily;
use Dataview\IOCompany\CBOOccupation;
use Dataview\IOCompany\CBOOccupationalProfile;
use Dataview\IOCompany\CBOSynonymous;
use Dataview\IOCompany\IOCompanyServiceProvider as SP;

class CBOSeeder extends Seeder
{
    public function run(){  

      $array = json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - Grande Grupo.json')), true);
      foreach($array as $c){
          CBOBigGroup::create([
              "id"=>$c['code'],
              "group"=>$c['name'],
          ]);
      }

      $array = json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - SubGrupo Principal.json')), true);
      foreach($array as $c){
          CBOMainSubgroup::create([
              "id"=>$c['code'],
              "subgroup"=>$c['name'],
          ]);
      }
      
      $array = json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - SubGrupo.json')), true);
      foreach($array as $c){
          CBOSubgroup::create([
              "id"=>$c['code'],
              "subgroup"=>$c['name'],
          ]);
      }
      
      $array = json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - Familia.json')), true);
      foreach($array as $c){
          CBOFamily::create([
              "id"=>$c['code'],
              "family"=>$c['name'],
          ]);
      }

      $array =  json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - Ocupacao.json')), true);
      foreach($array as $c){
          CBOOccupation::create([
              "id"=>$c['code'],
              "occupation"=>$c['name'],
          ]);
      }

      $array =  json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - PerfilOcupacional.json')), true);
      foreach($array as $c){
          CBOOccupationalProfile::create([
            'id_cbo_big_group' => (int) $c['cod_grupo_grande'],
            'id_cbo_main_subgroup' => $c['cod_subgrupo_principal'],
            'id_cbo_subgroup' => $c['cod_subgrupo'],
            'id_cbo_family' => $c['cod_familia'],
            'id_cbo_occupation' => $c['cod_ocupacao'],
            'codeBigArea' => $c['sgl_grande_area'],
            'bigArea' => $c['nome_grande_area'],
            'codeActivity' => (int) $c['cod_atividade'],
            'activity' => $c['nome_atividade']
        ]);
      }

      $array =  json_decode(file_get_contents(SP::pkgAddr('assets\src\cbo\CBO2002 - Sinonimo.json')), true);
      foreach($array as $c){
          CBOSynonymous::create([
            'id_cbo_occupation' => $c['code'],
            'synonymous' => $c['name']
        ]);
      }

    }
}
