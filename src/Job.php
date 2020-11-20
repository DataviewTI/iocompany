<?php
namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOModel;
use Dataview\IntranetOne\Group;
use Dataview\IOCompany\CharacterSet;
use Dataview\IOCompany\Attribute;
use Dataview\IOCompany\Candidate;

class Job extends IOModel
{
  protected $fillable = ['date_start', 'date_end', 'interval', 'gender', 'observations', 'hirer_info'];

  protected $appends = [
    'group' => false,
  ];

  protected $casts = [
    'hirer_info' => 'array'
  ];

  public function getCompatibleCandidates() {
    $characterSets = CharacterSet::all();
    $attributes = Attribute::with('characterSet')->get();
    $this->characterSetPoints = $this->getCharacterSetsPoints();
    $candidates = Candidate::where('answers', '!=', NULL)->with([
      'city',
      'graduations.graduationType',
      'jobExperiences.jobDuration',
      'jobExperiences.resignationReason',
      'degree'
    ])->get();

    foreach ($candidates as $candidate) {
      $candidate->characterSetPoints = $candidate->getCharacterSetsPoints($characterSets, $attributes);
      $candidate->characterSetPercentages = $this->calculatePercentage($candidate->characterSetPoints);
      $candidate->characterSets = $characterSets;
    }

    $compatibleCandidates = [];

    foreach ($candidates as $candidate) {
      if($this->sameOrder($this->characterSetPoints, $candidate->characterSetPoints))
        array_push($compatibleCandidates, $candidate);
    }

    return $compatibleCandidates;
  }

  public function getCharacterSetsPoints(){
    $characterSets = CharacterSet::all();
    $features = $this->features;

    $res = [];
    foreach ($characterSets as $characterSet) {
      $res[$characterSet->id] = 0;
    }

    foreach ($features as $feature) {
      $featureCharacterSets = $feature->characterSet;
      foreach ($featureCharacterSets as $featureCharacterSet) {
        $res[$featureCharacterSet->id]++;
      }
    }

    arsort($res);
    return $res;
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

  public function group(){
    return $this->belongsTo('Dataview\IntranetOne\Group');
  }

  public function cboOccupation()
  {
    return $this->belongsTo('Dataview\IOCompany\CBOOccupation');
  }

  public function profile()
  {
    return $this->belongsTo('Dataview\IOCompany\Profile');
  }

  public function features()
  {
    return $this->belongsToMany('Dataview\IOCompany\Feature', 'feature_job');
  }

  public function degree()
  {
    return $this->belongsTo('Dataview\IOCompany\Degree');
  }

  public function salary()
  {
    return $this->belongsTo('Dataview\IOCompany\Salary');
  }

  public function pcdType()
  {
    return $this->belongsTo('Dataview\IOCompany\PcdType', 'pcd_type_id');
  }

  public function company()
  {
    $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
    $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');
    if($hasSpatie) {
      return $this->belongsTo('\App\Company', 'company_id');
    } else {
      return $this->belongsTo('Dataview\IOCompany\Company', 'company_id');
    }
  }

  public static function boot(){
    parent::boot();
    static::created(function (Job $obj) {
      //   if($obj->getAppend("group") !== false){
      //     $group = new Group([
      //       'group' => $obj->getAppend("group"),
      //       'sizes' => $obj->getAppend("sizes")
      //     ]);
      //     $group->save();
      //     $obj->group()->associate($group)->save();
      // }
    });

  }
}
