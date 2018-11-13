<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CNAE extends Model
{
  public $incrementing = false;
  protected $table = 'cnae';
  protected $fillable = ['description'];
}
