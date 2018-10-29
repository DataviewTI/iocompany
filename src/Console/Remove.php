<?php
namespace Dataview\IOCompany\Console;
use Dataview\IntranetOne\Console\IOServiceRemoveCmd;
use Dataview\IOCompany\IOCompanyServiceProvider;
use Dataview\IntranetOne\IntranetOne;


class Remove extends IOServiceRemoveCmd
{
  public function __construct(){
    parent::__construct([
      "service"=>"company",
      "tables" =>['companies'],
    ]);
  }

  public function handle(){
    parent::handle();
  }
}
