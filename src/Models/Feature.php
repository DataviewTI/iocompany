<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
  protected $fillable = ['feature'];

  public function profiles(){
      return $this->belongsToMany('Dataview\IOCompany\Profile');
  }
}
