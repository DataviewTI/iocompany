<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Dataview\IOCompany\CompanyRequest;
use Dataview\IOCompany\Company;
use Dataview\IOCompany\CBOOccupation;
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
	
	public function simplifiedList(){
    $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
    $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');  
  
    if($hasSpatie) {
      $query = \App\Company::select('cnpj','razaoSocial','nomeFantasia')
      ->with([
        'roles'
      ])
      ->get();
    } else {
      $query = Company::select("cnpj",'razaoSocial','nomeFantasia')->get();
    }
  
    return json_encode($query);
  }
  
  public function list(){
    $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
    $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');  

    if($hasSpatie) {
      $query = \App\Company::select('cnpj','razaoSocial','nomeFantasia', 'active')
      ->with([
        'group'=>function($query){
          $query->select('groups.id','sizes');
        },
        'roles'
      ])
      ->get();
    } else {
      $query = Company::select('cnpj','razaoSocial','nomeFantasia', 'active')
      ->with([
        'group'=>function($query){
          $query->select('groups.id','sizes');
        }
      ])
      ->get();
    }

    return Datatables::of(collect($query))->make(true);
  }


	public function cboList($kw=null){
    $query = CBOOccupation::select('id as i','occupation as o');

    // $query->where('occupation','like',('%'.$kw.'%'))
    //   ->with([
    //       'synonym'=>function($query){
    //       $query->select('groups.id','sizes')
    //       ->with('files');
    //     },
    //   ])
    //   ->limit(200);
  
    return Datatables::of(collect($query->get()))->make(true);
  }
  
    

	public function create(CompanyRequest $request){
    // dump($request->all());

    $check = $this->__create($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
    $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');  

    if($hasSpatie) {
      $obj = new \App\Company($request->all());
      $password = str_random(8);
      $obj->password = Hash::make($password);
      if($request->recruiter){
        $obj->assignRole('recruiter');
      }
      $obj->save();
      // dump($obj);
      // dump($obj->getRoleNames());
      return response()->json(['success'=>true,'data'=>$obj]);
  
    } else {
      $obj = new Company($request->all());
      $obj->password = Hash::make(str_random(8));
      $obj->save();

      return response()->json(['success'=>true,'data'=>$obj]);
    }

	}

  public function view($id){

    $check = $this->__view();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
    $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');  
  
    if($hasSpatie) {
      $query = \App\Company::select('cnpj','razaoSocial','nomeFantasia','phone','mobile','zipCode','address','address2','city_id','email','numberApto')
      ->with([
        'group'=>function($query){
          $query->select('groups.id','sizes')
          ->with('files');
        },
        'roles'
      ])
      ->where('cnpj',$id)
      ->get();
    } else {
      $query = Company::select('cnpj','razaoSocial','nomeFantasia','phone','mobile','zipCode','address','address2','city_id','email','numberApto')
      ->with([
        'group'=>function($query){
          $query->select('groups.id','sizes')
          ->with('files');
        },
      ])
      ->where('cnpj',$id)
      ->get();
    }
				
    return response()->json(['success'=>true,'data'=>$query]);
	}
	
	public function update($id,CompanyRequest $request){
    $check = $this->__update($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

      $_new = (object) $request->all();
      $_old = Company::find($id);
      
      $upd = ['address','address2','city_id','email','phone','mobile','nomeFantasia','razaoSocial','zipCode','numberApto'];

      foreach($upd as $u)
        $_old->{$u} = $_new->{$u};
      
      // if($_old->group != null){
      //   $_old->group->sizes = $_new->sizes;
      //   $_old->group->manageImages(json_decode($_new->__dz_images),json_decode($_new->sizes));
      //   $_old->group->save();
      // }
      // else{
      //   if(count(json_decode($_new->__dz_images))>0){
      //     $_old->group()->associate(Group::create([
      //       'group' => "Avatar da configuração ".$id,
      //       'sizes' => $_new->sizes
      //       ])
      //     );
      //     $_old->group->manageImages(json_decode($_new->__dz_images),json_decode($_new->sizes));
			// 	}
      // }
		
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
