<?php

namespace Dataview\IOCompany;
use Dataview\IntranetOne\IORequest;
use Sentinel;

class JobRequest extends IORequest
{
  public function sanitize(){
    $input = parent::sanitize();

    if($input['has_hirer_info'] == "true"){
      $input['hirer_info'] = json_encode([
        'cnpj' => $input['cnpj'],
        'razaoSocial' => $input['razaoSocial'],
        'nomeFantasia' => $input['nomeFantasia'],
        'phone' => $input['phone'],
        'mobile' => $input['mobile'],
        'email' => $input['email'],
        'zipCode' => $input['zipCode'],
        'address' => $input['address'],
        'numberApto' => $input['numberApto'],
        'address2' => $input['address2'],
        'city' => $input['city'],
        'state' => $input['state'],
      ]);
    } else {
      $input['hirer_info'] = null;
    }

    $input['date_start'] = $input['date_start_submit'];
    $input['date_end'] =  $input['date_end_submit'];

    $this->replace($input);
	}

  public function rules(){
    $this->sanitize();
    return [
    ];
  }
}
