<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
  protected $fillable = ['feature'];

  public function profiles(){
    return $this->belongsToMany('Dataview\IOCompany\Profile');
  }

  public function jobs(){
    return $this->belongsToMany('Dataview\IOCompany\Job', 'feature_job');
  }

  public function characterSet() {
    return $this->belongsToMany('Dataview\IOCompany\CharacterSet');
  }

}
