<?php

namespace Dataview\IOCompany;
use Dataview\IntranetOne\IORequest;
use Sentinel;

class CandidateRequest extends IORequest
{
  public function sanitize(){
    $input = parent::sanitize();

    $input['cnpj'] =  preg_replace("/[^0-9]/", "",$input['cnpj']);
    $input['city_id'] =  $input['__city'];

    $this->replace($input);
	}

  public function rules(){
    $this->sanitize();
    return [
    ];
  }
}
