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
      'Liderança' =>
        ['Confiante','Inovador','Perfeccionista','Receioso','Agregador','Autônomo','Competitivo','Constante','Decidido','Paciente','Preciso','Resoluto','Sociável'],
      'Estratégico' =>
        ['Receioso','Observador','Preciso','Perfeccionista','Planejador','Resoluto','Competitivo','Estratégico','Sociável','Agregador','Paciente','Constante'],
      'Tático' =>
        ['Persistente','Observador','Planejador','Resoluto','Competitivo','Decidido','Confiante','Inspirador','Sociável','Paciente','Constante','Agregador','Preciso'],
      'Operacional' =>
         ['Organizado','Verificador','Assistente','Resoluto','Competitivo','Decidido','Confiante','Inspirador','Sociável','Paciente','Constante','Afiliado','Preciso']
    ];

    $profiles = Profile::all();

    foreach($profiles as $p)
      Feature::select('id')->whereIn('feature',$features[$p->profile])
        ->get()
        ->map(function($t) use ($p){
          $p->features()->attach([$t['id']=>['created_at'=>Carbon::now()]]);
          return true;
        });    
  }
} 
