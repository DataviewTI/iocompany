<?php

namespace Dataview\IOCompany;
use Dataview\IntranetOne\IORequest;
use Sentinel;

class JobRequest extends IORequest
{
  public function sanitize(){
    $input = parent::sanitize();

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
