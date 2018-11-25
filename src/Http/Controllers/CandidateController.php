<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dataview\IntranetOne\Group;
use Dataview\IOCompany\CandidateRequest;
use Dataview\IOCompany\Candidate;
use Validator;
use DataTables;
use Session;
use Sentinel;

class CandidateController extends IOController{

	public function __construct(){
    $this->service = 'company';
	}

  public function index(){
		return view('Candidate::index');
	}
	
  public function list(){
		$query = Candidate::select('id','name', 'gender','birthday','cpf','apprentice','pcd_id','address_city')
    ->with('pcdType')
    ->get();
  
    return Datatables::of(collect($query))->make(true);
  }

	public function create(CandidateRequest $request){
	}

  public function view($id){
	}
	
	public function update($id,CandidateRequest $request){
	}

  public function delete($id){
  }

}
