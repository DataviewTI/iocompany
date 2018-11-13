<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOFamily extends Model
{
  public $incrementing = false;
  protected $table = 'cbo_families';
  protected $fillable = ['family'];
}
