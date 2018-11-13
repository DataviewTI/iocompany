<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOOccupationalProfile extends Model
{
  protected $table = 'cbo_occupational_profiles';
  protected $fillable = ['id_cbo_big_group','id_cbo_main_subgroup','id_cbo_subgroup','id_cbo_family','id_cbo_occupation','codeBigArea','bigArea','codeActivity','activity'];


	public function synonym(){
		return $this->belongsToMany('Dataview\IntranetOne\CBOSynonymous','cbo_synonym')->withPivot('id');
	}
}
