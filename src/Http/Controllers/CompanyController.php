<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dataview\IOCompany\CompanyRequest;
use Dataview\IOCompany\Company;
use Dataview\IntranetOne\Group;
use Validator;
use DataTables;
use Session;
use Sentinel;

class CompanyController extends IOController{

	public function __construct(){
    $this->service = 'company';
	}

  public function index(){
		return view('Company::index');
	}
	
	public function list(){
    $query = Company::select('cnpj')
    ->with([
      'group'=>function($query){
        $query->select('groups.id','sizes');
      }
    ])
    ->get();
  
    return Datatables::of(collect($query))->make(true);
  }

	public function create(CompanyRequest $request){
    $check = $this->__create($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	
      
    $obj = new Company($request->all());
    if($request->sizes!= null){
      $obj->setAppend("sizes",$request->sizes);
      //$obj->setAppend("has_images",$request->has_images);
      $obj->save();
    }
    //if($request->sizes!= null && $request->has_images>0){
      $obj->group->manageImages(json_decode($request->__dz_images),json_decode($request->sizes));
      $obj->save();
    //}

    return response()->json(['success'=>true,'data'=>null]);
	}

  public function view($id){
    $check = $this->__view();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $query = Company::select('cnpj')
      ->with([
          'group'=>function($query){
          $query->select('groups.id','sizes')
          ->with('files');
        },
      ])
      ->where('id',$id)
      ->get();
				
			return response()->json(['success'=>true,'data'=>$query]);
	}
	
	public function update($id,CompanyRequest $request){
    $check = $this->__update($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

      $_new = (object) $request->all();
      $_old = Company::find($id);
      
      $upd = [];

      foreach($upd as $u)
        $_old->{$u} = $_new->{$u};
      
      if($_old->group != null){
        $_old->group->sizes = $_new->sizes;
        $_old->group->manageImages(json_decode($_new->__dz_images),json_decode($_new->sizes));
        $_old->group->save();
      }
      else{
        if(count(json_decode($_new->__dz_images))>0){
          $_old->group()->associate(Group::create([
            'group' => "Avatar da configuração ".$id,
            'sizes' => $_new->sizes
            ])
          );
          $_old->group->manageImages(json_decode($_new->__dz_images),json_decode($_new->sizes));
				}
      }
		
      $_old->save();

			return response()->json(['success'=>$_old->save()]);
	}

  public function delete($id){
    $check = $this->__delete();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

      $obj = Company::find($id);
			$obj = $obj->delete();
			return  json_encode(['sts'=>$obj]);
  }

}
