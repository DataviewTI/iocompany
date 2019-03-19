<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\Profile;
use Dataview\IOCompany\Feature;
use Carbon\Carbon;

class FeatureProfilePivotSeeder extends Seeder
{
  public function run(){
    $features = [
      'Liderança' => [
        'Confiante',
        'Inovador',
        'Perfeccionista',
        'Prudente',
        'Agregador',
        'Autonomia',
        'Competitivo',
        'Persuasivo',
        'Decidido',
        'Paciente',
        'Preciso',
        'Resoluto',
        'Diplomacia'
      ],

      'Estratégico' => [
        'Prudente',
        'Observador',
        'Visionário',
        'Perfeccionista',
        'Planejador',
        'Resoluto',
        'Competitivo',
        'Estratégico',
        'Sociável',
        'Agregador',
        'Paciente',
        'Constante',
        'Inspirador'
      ],

      'Tático' => [
        'Persistencia',
        'Decidido',
        'Planejador',
        'Resoluto',
        'Competitivo',
        'Prático',
        'Confiante',
        'Inspirador',
        'Sociável',
        'Paciente',
        'Constante',
        'Agregador',
        'Preciso'
      ],

      'Operacional' => [
        'Organização',
        'Conferir',
        'Assistencia',
        'Resoluto',
        'Prestativo',
        'Decidido',
        'Confiante',
        'Humilde',
        'Sociável',
        'Paciente',
        'Foco',
        'Eficiência',
        'Preciso'
      ]
    ];

    $profiles = Profile::all();

    foreach($profiles as $p)
      Feature::select('id')->whereIn('feature',
        $features[$p->profile])
        ->get()
        ->map(function($t) use ($p){
          $p->features()->attach([$t['id']=>['created_at'=>Carbon::now()]]);
          return true;
        });    
  }
} 
