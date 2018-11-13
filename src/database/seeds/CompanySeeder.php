<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Faker\Factory as Factory;

use Dataview\IOCompany\Company;
use Dataview\IOCompany\City;


class CompanySeeder extends Seeder
{
    public function run(){
      $faker = Factory::create('pt_BR');
      $faker_us = Factory::create();

      for($i=0; $i<20; $i++){
        Company::create([
        'cnpj'=> $faker->cnpj(false),
        'razaoSocial'=> $faker->company(),
				'nomeFantasia'=> $faker_us->catchPhrase(),
        'phone'=> $faker->cellphoneNumber(),
        'mobile'=> $faker->cellphoneNumber(),
        'email'=> $faker->email(),
        'zipCode'=> '77410-971',
        'address'=> $faker->streetAddress(),
        'address2'=> $faker->streetName(),
        'numberApto'=> $faker->buildingNumber(),
        'city_id'=> City::inRandomOrder()->first()->id
      ]);
    }  
  }
} 
