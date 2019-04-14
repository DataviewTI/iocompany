@php
  use Dataview\IOCompany\Profile;
  use Dataview\IOCompany\Feature;
  use Dataview\IOCompany\Degree;
  use Dataview\IOCompany\Salary;
  use Dataview\IOCompany\PcdType;
  use Dataview\IOCompany\MaritalStatusType;
  use Dataview\IOCompany\ChildrenAmount;
  use Carbon\Carbon;

  $profiles = Profile::select('id','profile')->orderBy('profile')->get();
  $degrees = Degree::select('id','degree')->orderBy('order')->get();
  $salaries = Salary::select('id','salary')->orderBy('order')->get();
  $pcdTypes = PcdType::select('id','title')->orderBy('order')->get();
  $maritalStatus = MaritalStatusType::select('id','title')->orderBy('order')->get();
  $childrenAmounts = ChildrenAmount::select('id','title')->orderBy('order')->get();

  $feats = Profile::find(1)->features()->get();

@endphp

<div class = 'row'>
  <div class="col-sm-3 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'name' class="bmd-label-floating __required">Nome completo</label>
      <input type="text" class="form-control form-control-lg" id="name" name = 'name'>
    </div>
  </div>
  <div class="col-sm-3 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'social_name' class="bmd-label-floating __required">Nome social</label>
      <input type="text" class="form-control form-control-lg" id="social_name" name = 'social_name'>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'birthday' class="bmd-label-floating __required">Data de nascimento</label>
      <input type="text" class="form-control form-control-lg" id="birthday" name = 'birthday'>
    </div>
  </div>

  <div class="col-12 col-lg-4 pl-0">
    <label for = 'gender' class="bmd-label-floating __required">Sexo</label>
    <div class="form-group">
      <div class="form-check form-check-inline mr-0">
        <input class="form-check-input " type="radio" name="gender" value="Masculino">
        <label class="form-check-label bmd-label-floating __required" for="masculino">Masculino</label>
      </div>
      <div class="form-check form-check-inline mr-0">
        <input class="form-check-input " type="radio" name="gender" value="Feminino">
        <label class="form-check-label bmd-label-floating __required" for="feminino">Feminino</label>
      </div>
      <div class="form-check form-check-inline mr-0 d-none">
        <input class="form-check-input " type="radio" name="gender" id="outros" value="Outros">
        <label class="form-check-label bmd-label-floating __required" for="outros">Outro</label>
        <input type="text" class="form-control form-control-lg ml-3 p-0 w-100" id="other_gender" name = 'other_gender'>
      </div>
    </div>
  </div>
</div>

<div class = 'row'>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'cpf' class="bmd-label-floating __required">CPF</label>
      <input type="text" class="form-control form-control-lg" id="cpf" name = 'cpf'>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'rg' class="bmd-label-floating __required">RG</label>
      <input type="text" class="form-control form-control-lg" id="rg" name = 'rg'>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'cnh' class="bmd-label-floating __required">CNH</label>
      <input type="text" class="form-control form-control-lg" id="cnh" name = 'cnh'>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-3 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'marital_status' class="bmd-label-floating __required">Estado civil</label>
      <select name = 'marital_status' id = 'marital_status' class = 'form-control form-control-lg custom-select'>
        <option value = ''>&nbsp;</option>
        @foreach ($maritalStatus as $ms)
          <option value = '{{ $ms->id }}'>{{ $ms->title }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-sm-3 col-xs-12 ">
    <div class="form-group">
      <label for = 'children_amount' class="bmd-label-floating __required">Número de filhos</label>
      <select name = 'children_amount' id = 'children_amount' class = 'form-control form-control-lg custom-select'>
        <option value = ''>&nbsp;</option>
        @foreach ($childrenAmounts as $ca)
          <option value = '{{ $ca->id }}'>{{ $ca->title }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'apprentice' class="bmd-label-floating __required">Aprendiz</label>
      <select name = 'apprentice' id = 'apprentice' class = 'form-control form-control-lg custom-select'>
        <option value = 'S'>Sim</option>
        <option value = 'N' selected>Não</option>
      </select>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'pcd' class="bmd-label-floating __required">PCD</label>
      <select name = 'pcd' id = 'pcd' class = 'form-control form-control-lg custom-select'>
        <option value = ''>Não</option>
        <optgroup label = 'Sim'>
          @foreach ($pcdTypes as $pcdType)
            <option value = '{{ $pcdType->id }}'>{{ $pcdType->title }}</option>
          @endforeach
        </optgroup>
      </select>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 ">
    <div class="form-group">
      <label for = 'salary' class="bmd-label-floating __required">Pretensão salarial</label>
      <select name = 'salary' id = 'salary' class = 'form-control form-control-lg custom-select'>
        <option value = ''>&nbsp;</option>
        @foreach($salaries as $s)
          <option value = '{{$s->id}}'>{{$s->salary}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>

<div class = 'row'>
  <div class="col-sm-7 col-xs-12 p-0">
    <div class = 'row'>
      <div class="col-sm-3 col-xs-12">
        <div class="form-group">
          <label for = 'phone' class="bmd-label-floating __required">Telefone Fixo</label>
          <input name = 'phone' type = 'tel' id = 'phone' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-3 col-xs-12">
        <div class="form-group">
          <label for = 'mobile' class="bmd-label-floating">Celular/WhatsApp</label>
          <input name = 'mobile' type = 'tel' id = 'mobile' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="form-group">
          <label for = 'email' class="bmd-label-floating __required">Email</label>
          <input name = 'email' type = 'email' id = 'email' class = 'form-control form-control-lg' />
        </div>
      </div>
    </div>
  </div>
</div>

<div class = 'row'>
  <div class="col-sm-7 col-xs-12 pl-0">
    <div class = 'row'>
      <div class="col-sm-2 col-xs-12 pr-0">
        <div class="form-group">
          <label for = 'zipCode' class="bmd-label-floating __required">CEP</label>
          <input name = 'zipCode' type = 'tel' id = 'zipCode' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-8 col-xs-12">
        <div class="form-group">
          <label for = 'address_street' class="bmd-label-floating __required">Logradouro</label>
          <input name = 'address_street' type = 'text' id = 'address_street' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-2 col-xs-12">
        <div class="form-group">
          <label for = 'address_number' class="bmd-label-floating __required">Nº / Apto</label>
          <input name = 'address_number' type = 'text' id = 'address_number' class = 'form-control form-control-lg' />
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-5 col-xs-12">
    <div class = 'row pr-3'>
      <div class="col-sm-5 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'address_district' class="bmd-label-floating __required">Bairro</label>
          <input name = 'address_district' type = 'text' id = 'address_district' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-6 col-xs-9 pl-0">
        <div class="form-group">
          <label for = 'address_city' class="bmd-label-floating __required">Cidade</label>
          <input name = 'address_city' type = 'tel' id = 'address_city' data-ibge = '' class = 'form-control form-control-lg' disabled/>
          <input name = '__city' type = 'hidden' id = '__city' />
        </div>
      </div>
      <div class="col-sm-1 col-xs-3 px-0">
        <div class="form-group">
          <label for = 'address_state' class="bmd-label-floating __required">UF</label>
          <input name = 'address_state' type = 'text' id = 'address_state' class = 'form-control form-control-lg' disabled />
          <input name = '__state' type = 'hidden' id = '__state' />
        </div>
      </div>
    </div>
  </div>
</div>

@section('before_body_close')
  @include('Job::cbo-modal')
@endsection

