<?php
namespace Dataview\IOCompany;

use Illuminate\Database\Seeder;
use Dataview\IOCompany\Feature;

class FeatureSeeder extends Seeder
{
  public function run(){

    $features = ['Afiliado','Agregador','Assitente','Autônomo','Competitivo','Confiante','Constante','Decidido',
    'Estrategista','Inovador','Inspirador','Observador','Organizado','Paciente','Perfeccionista',
    'Persistente','Planejador','Preciso','Receioso','Resoluto','Sociável','Verificador'];
    
    foreach($features as $f)
      Feature::create(["feature"=>$f]);
  }
} 




