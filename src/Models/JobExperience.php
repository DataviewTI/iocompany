<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class JobExperience extends Model
{
  protected $fillable = ['type', 'company', 'role'];

  public function candidate()
  {
    return $this->belongsTo('Dataview\IOCompany\Candidate', 'candidate_id');
  }

  public function jobDuration()
  {
    return $this->belongsTo('Dataview\IOCompany\JobDuration');
  }

  public function resignationReason()
  {
    return $this->belongsTo('Dataview\IOCompany\ResignationReason');
  }

}
