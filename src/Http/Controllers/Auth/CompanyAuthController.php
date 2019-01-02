<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dataview\IOCompany\Company;
use App\Facades\CompanySentinel;
use Illuminate\Support\MessageBag;

class CompanyAuthController extends IOController{

    protected $messageBag = null;
		
    public function __construct(){
        $this->messageBag = new MessageBag;
    }

    public function signin(Request $request)
    {
        try
        {
            if (CompanySentinel::authenticate($request->only(['cnpj', 'password']), true)){
                return redirect('empresa/dashboard');//deve ser o alias
            }
            $this->messageBag->add('email','CNPJ e/ou senha não conferem!');

        }
        catch (NotActivatedException $e)
        {
            $this->messageBag->add('notActivated','Esta conta não está ativada. Verifique seu email pelo link de ativação');
        }
        catch (ThrottlingException $e)
        {
            $delay = $e->getDelay();
            $this->messageBag->add('accountSuspended','Conta suspensa temporariamente');
        }
        return json_encode(['status'=>false,'message_bag'=>$this->messageBag]);

    }

    public function signout()
    {
        CompanySentinel::logout();
        return redirect('empresa/login');//deve ser o alias
    }

}
