<?php

namespace Dataview\IOCompany;
use Dataview\IntranetOne\IORequest;
use Sentinel;

class CandidateRequest extends IORequest
{
  public function sanitize(){
    $input = parent::sanitize();

    if(isset($input['birthday_submit']))
      $input['birthday'] = $input['birthday_submit'];
    $input['cpf'] = str_replace(".", "", $input['cpf']);
    $input['cpf'] = str_replace("-", "", $input['cpf']);
    
    if(isset($input['__city']))
      $input['address_city'] = $input['__city'];
    if(isset($input['__state']))
      $input['address_state'] = $input['__state'];

    $this->replace($input);
	}

  public function rules(){
    $this->sanitize();
    return [
    ];
  }
}
