<?php
namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOModel;
use Dataview\IntranetOne\File as ProjectFile;
use Dataview\IntranetOne\Group;
use Illuminate\Support\Facades\Storage;

class Company extends IOModel
{
  protected $fillable = ['cnpj'];

  protected $casts = [
    'data' => 'array',
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
