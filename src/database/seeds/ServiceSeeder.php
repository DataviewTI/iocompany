<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IntranetOne\Service;
use Faker\Generator as Faker;
use Faker\Factory as Factory;
use Sentinel;

class ServiceSeeder extends Seeder
{
    public function run(){
      $serv = 'Company';
      $faker = Factory::create('pt_BR');

      if(!Service::where('service',$serv)->exists()){
        Service::insert([
            'service' => $serv,
            'alias' =>str_slug($serv),
            'ico' => 'ico-save',
            'description' => "Company forms",
            'order' => Service::max('order')+1
          ]);
      }

      if(!Service::where('service','Job')->exists()){
        Service::insert([
            'service' => 'Job',
            'alias' =>'job',
            'ico' => 'ico-idea',
            'description' => "Jobs vacancies for Companies",
            'order' => Service::max('order')+1
          ]);
      }      

      if(!Service::where('service','Candidate')->exists()){
        Service::insert([
            'service' => 'Candidate',
            'alias' =>'candidate',
            'ico' => 'ico-manager',
            'description' => "Candidates management",
            'order' => Service::max('order')+1
          ]);
      }      

      //seta privilegios padrão para o user odin/admin

      $odinRole = Sentinel::findRoleBySlug('odin');
      $odinRole->addPermission(strtolower($serv).'.view');
      $odinRole->addPermission(strtolower($serv).'.create');
      $odinRole->addPermission(strtolower($serv).'.update');
      $odinRole->addPermission(strtolower($serv).'.delete');
      $odinRole->addPermission(strtolower('candidate').'.view');
      $odinRole->addPermission(strtolower('candidate').'.create');
      $odinRole->addPermission(strtolower('candidate').'.update');
      $odinRole->addPermission(strtolower('candidate').'.delete');
      $odinRole->addPermission(strtolower('job').'.view');
      $odinRole->addPermission(strtolower('job').'.create');
      $odinRole->addPermission(strtolower('job').'.update');
      $odinRole->addPermission(strtolower('job').'.delete');
      $odinRole->save();

      $adminRole = Sentinel::findRoleBySlug('admin');
      $adminRole->addPermission(strtolower($serv).'.view');
      $adminRole->addPermission(strtolower($serv).'.create');
      $adminRole->addPermission(strtolower($serv).'.update');
      $adminRole->addPermission(strtolower($serv).'.delete');
      $adminRole->addPermission(strtolower('candidate').'.view');
      $adminRole->addPermission(strtolower('candidate').'.create');
      $adminRole->addPermission(strtolower('candidate').'.update');
      $adminRole->addPermission(strtolower('candidate').'.delete');
      $adminRole->addPermission(strtolower('job').'.view');
      $adminRole->addPermission(strtolower('job').'.create');
      $adminRole->addPermission(strtolower('job').'.update');
      $adminRole->addPermission(strtolower('job').'.delete');
      $adminRole->save();

      // call aditional seeds
      $this->call(CitiesSeeder::class);
      $this->call(CBOSeeder::class);
      $this->call(CNAESeeder::class);
      $this->call(ProfileSeeder::class);
      $this->call(FeatureSeeder::class);
      $this->call(FeatureProfilePivotSeeder::class);
      $this->call(DegreeSeeder::class);
      $this->call(SalarySeeder::class);
      $this->call(CompanySeeder::class);
      $this->call(ChildrenAmountSeeder::class);
      $this->call(GraduationTypeSeeder::class);
      $this->call(JobDurationSeeder::class);
      $this->call(PcdTypeSeeder::class);
      $this->call(ResignationReasonSeeder::class);
      $this->call(MaritalStatusTypeSeeder::class);
    }
  } 
