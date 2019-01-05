<?php
namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOModel;
use Dataview\IntranetOne\Group;

class Job extends IOModel
{
  protected $fillable = ['date_start', 'date_end', 'interval', 'gender', 'observations', 'hirer_info'];

  protected $appends = [
    'group' => false,
  ];

  protected $casts = [
    'hirer_info' => 'array'
  ];

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
    return $this->belongsTo('Dataview\IOCompany\Company', 'company_id');
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
