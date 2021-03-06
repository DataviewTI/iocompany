<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;
use Dataview\IOCompany\Graduation;
use Dataview\IOCompany\GraduationType;
use Dataview\IOCompany\JobExperience;
use Dataview\IOCompany\JobDuration;
use Dataview\IOCompany\ResignationReason;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Dataview\IOCompany\CharacterSet;
use Dataview\IOCompany\Attribute;
use Dataview\IOCompany\Job;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;

  protected $fillable = [
    'id',
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
    'password',
    'last_login',
    'remember_token',
    'answers',
    'marital_status_type_id',
    'group_id',
    'degre_id',
    'pcd_type_id',
    'pcd_group_id',
    'salary_id',
    'children_amount_id',
    'complete_profile',
  ];

  public function profileEvaluation() {
    $characterSets = CharacterSet::all();
    $attributes = Attribute::with('characterSet')->get();

    $characterSetPoints = $this->getCharacterSetsPoints($characterSets, $attributes);
    $characterSetPercentages = $this->calculatePercentage($characterSetPoints);

    return [
        'characterSetPoints' => $characterSetPoints,
        'characterSetPercentages' => $characterSetPercentages,
    ];
  }

  public function getCompatibleJobs() {
    $characterSets = CharacterSet::all();
    $attributes = Attribute::with('characterSet')->get();

    $jobs = Job::with([
        'profile',
        'degree',
        'company',
        'company',
        'cboOccupation',
        'salary',
        'pcdType',
        'features',
    ])->get();

    foreach ($jobs as $job) {
      $job->characterSetPoints = $job->getCharacterSetsPoints($characterSets, $attributes);
    }

    $compatibleJobs = [];

    if($this->answers != null) {
      foreach ($jobs as $job) {
        if($this->sameOrder($this->getCharacterSetsPoints($characterSets, $attributes), $job->characterSetPoints))
          array_push($compatibleJobs, $job);
      }
    }

    return $compatibleJobs;
  }

  public function calculatePercentage($points) {
    $total = 0;
    foreach ($points as $point) {
      $total += $point;
    }

    $res = [];
    foreach ($points as $key => $value) {
      $res[$key] = (($value / $total) * 100);
    }

    return $res;
  }

  public function sameOrder($a, $b) {
    $keysA = [];
    $keysB = [];
    foreach ($a as $key => $value) {
      array_push($keysA, $key);
    }

    foreach ($b as $key => $value) {
      array_push($keysB, $key);
    }

    for ($i=0; $i < count($keysA); $i++) {
      if($keysA[$i] != $keysB[$i])
        return false;
    }

    return true;
  }

  public function getCharacterSetsPoints($characterSets, $attributes){
    $answers = json_decode($this->answers);

    $res = [];
    foreach ($characterSets as $characterSet) {
      $res[$characterSet->id] = 0;
    }
    foreach ($answers as $answer) {
      $res[$answer->character_set_id] += $answer->value;
    }
    arsort($res);
    return $res;
  }

  public function palmjobNotifications()
  {
    return $this->hasMany('Dataview\IOCompany\PalmjobNotification', 'candidate_cpf', 'cpf');
  }

  public function city(){
    return $this->belongsTo('Dataview\IOCompany\City', 'address_city');
  }

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

  public function manageGraduations($graduations)
  {
    $_graduations = [];

    if($graduations != null && $graduations != "" && $graduations != " "){
      foreach($graduations as $graduation)
      {
        $graduation  = (object) $graduation;

        if(!property_exists($graduation, 'id') || $graduation->id == null) {
          $_graduation = new Graduation([
            'institution' => $graduation->institution,
            'ending' => $graduation->ending,
            'school' => $graduation->school,
          ]);
          $_graduation->graduationType()->associate(GraduationType::where('id', $graduation->graduation_type_id)->first());

          $this->graduations()->save($_graduation);
          array_push($_graduations,$_graduation->id);
        } else {
          $__upd = Graduation::find($graduation->id);//->id)->get();
          $__upd->update([
            'institution' => $graduation->institution,
            'ending' => $graduation->ending,
            'school' => $graduation->school,
          ]);
          $__upd->graduationType()->dissociate();
          $__upd->graduationType()->associate(GraduationType::where('id', $graduation->graduation_type_id)->first());

          array_push($_graduations,$graduation->id);
        }
      }
    }

		$to_remove = array_diff(array_column($this->graduations()->get()->toArray(),'id'),$_graduations);
		Graduation::destroy($to_remove);
	}

  public function manageJobExperiences($jobs)
  {
    $_jobs = [];

    if($jobs != null && $jobs != "" && $jobs != " "){
      foreach($jobs as $job)
      {
        $job  = (object) $job;

        if(!property_exists($job, 'id') || $job->id == null){
          $_job = new JobExperience([
            'type' => $job->job_type,
            'company' => $job->company,
            'role' => $job->role,
          ]);
          $_job->jobDuration()->associate(JobDuration::where('id', $job->job_duration_id)->first());
          if($job->job_type == 'J')
            $_job->resignationReason()->associate(ResignationReason::where('id', $job->resignation_reason_id)->first());

          $this->jobExperiences()->save($_job);
          array_push($_jobs,$_job->id);
        } else {
          $__upd = JobExperience::find($job->id);//->id)->get();
          $__upd->update([
            'type' => $job->job_type,
            'company' => $job->company,
            'role' => $job->role,
          ]);
          $__upd->jobDuration()->dissociate();
          $__upd->resignationReason()->dissociate();

          $__upd->jobDuration()->associate(JobDuration::where('id', $job->job_duration_id)->first());
          if($job->job_type == 'J')
            $__upd->resignationReason()->associate(ResignationReason::where('id', $job->resignation_reason_id)->first());

          array_push($_jobs,$job->id);
        }
      }
    }

		$to_remove = array_diff(array_column($this->jobExperiences()->get()->toArray(),'id'),$_jobs);
		JobExperience::destroy($to_remove);
	}

}
