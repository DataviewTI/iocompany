<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\Profile;

class ProfileSeeder extends Seeder
{
  public function run(){

    $profiles = ['Liderança','Estratégico','Tático','Operacional'];

    foreach($profiles as $p)
      Profile::create(["profile"=>$p]);

  }
} 
