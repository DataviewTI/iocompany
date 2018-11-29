<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Graduation extends Model
{
  protected $fillable = ['title', 'institution', 'school', 'ending', 'order'];

  public function candidate()
  {
    return $this->belongsTo('Dataview\IOCompany\Candidate');
  }

  public function graduationType()
  {
    return $this->belongsTo('Dataview\IOCompany\GraduationType');
  }

}
