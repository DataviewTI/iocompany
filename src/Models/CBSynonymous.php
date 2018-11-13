<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOSynonymous extends Model
{
  protected $table = 'cbo_synonym';
  protected $fillable = ['id_cbo_occupation','synonymous'];
}
