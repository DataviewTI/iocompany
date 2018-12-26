<?php
namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOModel;
// use Dataview\IntranetOne\File as ProjectFile;
use Dataview\IntranetOne\Group;
// use Illuminate\Support\Facades\Storage;

class Company extends IOModel
{
  protected  $primaryKey = 'cnpj';
  public $incrementing = false;

  protected $fillable = [
    'cnpj',
    'razaoSocial',
    'nomeFantasia',
    'phone1',
    'phone',
    'mobile',
    'mobile2',
    'email',
    'zipCode',
    'address',
    'address2',
    'numberApto',
    'city_id',
    'group_id',
    'description',
    'data',
    'last_login',
    'remember_token',
  ];

  protected $appends = [
    'group' => false,
  ];


  protected $casts = [
    'data' => 'array',
    'cnpj' => 'string'
  ];

  public function group(){
    return $this->belongsTo('Dataview\IntranetOne\Group');
  }

  public function jobs()
  {
    return $this->hasMany('Dataview\IOCompany\Job');
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
