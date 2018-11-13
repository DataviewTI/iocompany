<?php
namespace Dataview\IOCompany\Console;
use Dataview\IntranetOne\Console\IOServiceInstallCmd;
use Dataview\IOCompany\IOCompanyServiceProvider;
use Dataview\IOCompany\ServiceSeeder;

class Install extends IOServiceInstallCmd
{
  public function __construct(){
    parent::__construct([
      "service"=>"company",
      "provider"=> IOCompanyServiceProvider::class,
      "seeder"=>ServiceSeeder::class,
    ]);
  }

  public function handle(){
    parent::handle();
  }
}
