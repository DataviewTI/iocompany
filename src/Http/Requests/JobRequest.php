<?php

namespace Dataview\IOCompany;
use Dataview\IntranetOne\IORequest;
use Sentinel;

class JobRequest extends IORequest
{
  public function sanitize(){
    $input = parent::sanitize();
    $this->replace($input);
	}

  public function rules(){
    $this->sanitize();
    return [
    ];
  }
}
