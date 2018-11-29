<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
  protected $fillable = [
    'name',
    'social_name',
    'gender',
    'birthday',
    'cpf',
    'cnh',
    'rg',
    'zipCode',
    'address_street',
    'address_number',
    'address_district',
    'address_city',
    'address_state',
    'phone',
    'mobile',
    'email',
    'apprentice',
  ];

  public function graduations()
  {
    return $this->hasMany('Dataview\IOCompany\Graduation');
  }

  public function maritalStatus()
  {
    return $this->belongsTo('Dataview\IOCompany\MaritalStatusType', 'marital_status_type_id');
  }

  public function degree()
  {
    return $this->belongsTo('Dataview\IOCompany\Degree', 'degree_id');
  }

  public function jobExperiences()
  {
    return $this->hasMany('Dataview\IOCompany\JobExperience');
  }

  public function pcdType()
  {
    return $this->belongsTo('Dataview\IOCompany\PcdType', 'pcd_type_id');
  }

  public function childrenAmount()
  {
    return $this->belongsTo('Dataview\IOCompany\ChildrenAmount', 'children_amount_id');
  }

  public function salary()
  {
    return $this->belongsTo('Dataview\IOCompany\Salary', 'salary_id');
  }

  public function pcdGroup()
  {
    return $this->belongsTo('Dataview\IOCompany\Group');
  }

}
