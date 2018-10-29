<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IntranetOne\Service;
use Illuminate\Support\Facades\Artisan;
use Faker\Generator as Faker;
use Faker\Factory as Factory;

use Sentinel;
use Dataview\IOCompany\Company;


class CompanySeeder extends Seeder
{
    public function run(){
      $serv = 'Company';
      $faker = Factory::create('pt_BR');


      if(!Service::where('service',$serv)->exists()){
        Service::insert([
            'service' => $serv,
            'alias' =>str_slug($serv),
            'ico' => 'ico-gears',
            'description' => "Company forms",
            'order' => Service::max('order')+1
          ]);
      }
      //seta privilegios padrão para o user odin/admin

      $odinRole = Sentinel::findRoleBySlug('odin');
      $odinRole->addPermission(strtolower($serv).'.view');
      $odinRole->addPermission(strtolower($serv).'.create');
      $odinRole->addPermission(strtolower($serv).'.update');
      $odinRole->addPermission(strtolower($serv).'.delete');
      $odinRole->save();

      $adminRole = Sentinel::findRoleBySlug('admin');
      $adminRole->addPermission(strtolower($serv).'.view');
      $adminRole->addPermission(strtolower($serv).'.create');
      $adminRole->addPermission(strtolower($serv).'.update');
      $adminRole->addPermission(strtolower($serv).'.delete');
      $adminRole->save();

      //criar a seed das empresas

    }
} 
