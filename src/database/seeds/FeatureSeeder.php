<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\Feature;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
  public function run(){
    DB::table('features')->insert([
      ['id' => 1, 'feature' => 'Confiante'],
      ['id' => 2, 'feature' => 'Inovador'],
      ['id' => 3, 'feature' => 'Perfeccionista'],
      ['id' => 4, 'feature' => 'Prudente'],
      ['id' => 5, 'feature' => 'Agregador'],
      ['id' => 6, 'feature' => 'Autonomia'],
      ['id' => 7, 'feature' => 'Competitivo'],
      ['id' => 8, 'feature' => 'Decidido'],
      ['id' => 9, 'feature' => 'Paciente'],
      ['id' => 10, 'feature' => 'Preciso'],
      ['id' => 11, 'feature' => 'Resoluto'],
      ['id' => 12, 'feature' => 'Observador'],
      ['id' => 13, 'feature' => 'Visionário'],
      ['id' => 14, 'feature' => 'Planejador'],
      ['id' => 15, 'feature' => 'Estratégico'],
      ['id' => 16, 'feature' => 'Sociável'],
      ['id' => 17, 'feature' => 'Constante'],
      ['id' => 18, 'feature' => 'Inspirador'],
      ['id' => 19, 'feature' => 'Persistência'],
      ['id' => 20, 'feature' => 'Prático'],
      ['id' => 21, 'feature' => 'Organização'],
      ['id' => 22, 'feature' => 'Conferir'],
      ['id' => 23, 'feature' => 'Assistência'],
      ['id' => 24, 'feature' => 'Prestativo'],
      ['id' => 25, 'feature' => 'Humilde'],
      ['id' => 26, 'feature' => 'Foco'],
      ['id' => 27, 'feature' => 'Eficiência'],
      ['id' => 28, 'feature' => 'Persuasivo'],
      ['id' => 29, 'feature' => 'Diplomacia'],
   ]);

  //   $features = [
  //     'Afiliado',
  //     'Agregador',
  //     'Assitente',
  //     'Autônomo',
  //     'Competitivo',
  //     'Confiante',
  //     'Constante',
  //     'Decidido',

  //     'Estrategista',
  //     'Inovador',
  //     'Inspirador',
  //     'Observador',
  //     'Organizado',
  //     'Paciente',
  //     'Perfeccionista',

  //     'Persistente',
  //     'Planejador',
  //     'Preciso',
  //     'Receioso',
  //     'Resoluto',
  //     'Sociável',
  //     'Verificador'
  //   ];
    
  //   foreach($features as $f)
  //     Feature::create(["feature"=>$f]);
  }
} 




