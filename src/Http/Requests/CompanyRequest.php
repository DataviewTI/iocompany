<?php

namespace Dataview\IOCompany;
use Dataview\IntranetOne\IORequest;
use Sentinel;

class CompanyRequest extends IORequest
{
  public function sanitize(){
    $input = parent::sanitize();

    $input['active'] = (int)($input['__active']=='true');
    if(array_has($input, '__recruiter')){
      $input['recruiter'] = (int)($input['__recruiter']=='true');
    }

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
