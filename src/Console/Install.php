<?php
namespace Dataview\IOCompany\Console;
use Dataview\IntranetOne\Console\IOServiceInstallCmd;
use Dataview\IOCompany\IOCompanyServiceProvider;
use Dataview\IOCompany\CompanySeeder;

class Install extends IOServiceInstallCmd
{
  public function __construct(){
    parent::__construct([
      "service"=>"company",
      "provider"=> IOCompanyServiceProvider::class,
      "seeder"=>CompanySeeder::class,
    ]);
  }

  public function handle(){
    parent::handle();
  }
}
