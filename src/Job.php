<?php
namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOModel;
use Dataview\IntranetOne\Group;

class Job extends IOModel
{
  protected $fillable = [];

  protected $appends = [
    'group' => false,
  ];


  protected $casts = [
  ];

  public function group(){
    return $this->belongsTo('Dataview\IntranetOne\Group');
  }

  public static function boot(){
    parent::boot(); 
    static::created(function (Company $obj) {
        if($obj->getAppend("group") !== false){
          $group = new Group([
            'group' => $obj->getAppend("group"),
            'sizes' => $obj->getAppend("sizes")
          ]);
          $group->save();
          $obj->group()->associate($group)->save();
      }
    });
    
  }
}
