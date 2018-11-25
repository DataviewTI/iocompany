@php
  use Dataview\IOCompany\Profile;
  use Dataview\IOCompany\Feature;
  use Dataview\IOCompany\Degree;
  use Dataview\IOCompany\Salary;
  use Carbon\Carbon;

  $profiles = Profile::select('id','profile')->orderBy('profile')->get();
  $degrees = Degree::select('id','degree')->orderBy('order')->get();
  $salaries = Salary::select('id','salary')->orderBy('order')->get();

  $feats = Profile::find(1)->features()->get();

@endphp

<div class = 'row'>
  <div class="col-sm-3 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">Nome completo</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-sm-3 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">Nome social</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">Data de nascimento</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-12 col-lg-4 pl-0">
    <label for = 'date_start' class="bmd-label-floating __required">Sexo</label>
    <div class="form-group">
      <div class="form-check form-check-inline mr-0">
        <input class="form-check-input " type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
        <label class="form-check-label bmd-label-floating __required" for="inlineRadio1">Masculino</label>
      </div>
      <div class="form-check form-check-inline mr-0">
        <input class="form-check-input " type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
        <label class="form-check-label bmd-label-floating __required" for="inlineRadio2">Feminino</label>
      </div>
      <div class="form-check form-check-inline mr-0">
        <input class="form-check-input " type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
        <label class="form-check-label bmd-label-floating __required" for="inlineRadio3">Outro</label>
        <input disabled type="text" class="form-control form-control-lg ml-3 p-0 w-100" id="date_start" name = 'date_start'>
      </div>
    </div>
  </div>
</div>

<div class = 'row'>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">CPF</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">RG</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">CNH</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-3 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">Estado civil</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-sm-3 col-xs-12 ">
    <div class="form-group">
      <label for = 'date_start' class="bmd-label-floating __required">Número de filhos</label>
      <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'cboa' class="bmd-label-floating __required">Aprendiz</label>
      <select name = 'sexo' id = 'sexo' class = 'form-control form-control-lg custom-select'>
        <option value = 'S'>Sim</option>
        <option value = 'N' selected>Não</option>
      </select>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'pcd' class="bmd-label-floating __required">PCD</label>
      <select name = 'pcd' id = 'pcd' class = 'form-control form-control-lg custom-select'>
        <option value = 'Não'>Não</option>
        <optgroup label = 'Sim'>
          <option value = 'Visual'>Visual</option>
          <option value = 'Auditivo'>Auditivo</option>
          <option value = 'Físico'>Físico</option>
          <option value = 'Mental'>Mental</option>
          <option value = 'Multipla'>Multipla</option>
        </optgroup>
      </select>
    </div>
  </div>
  <div class="col-sm-2 col-xs-12 ">
    <div class="form-group">
      <label for = 'pcd' class="bmd-label-floating __required">Pretensão salarial</label>
      <select name = 'pcd' id = 'pcd' class = 'form-control form-control-lg custom-select'>
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
          <label for = 'address' class="bmd-label-floating __required">Logradrouro</label>
          <input name = 'address' type = 'text' id = 'address' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-2 col-xs-12">
        <div class="form-group">
          <label for = 'numberApto' class="bmd-label-floating __required">Nº / Apto</label>
          <input name = 'numberApto' type = 'text' id = 'numberApto' class = 'form-control form-control-lg' />
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-5 col-xs-12">
    <div class = 'row pr-3'>
      <div class="col-sm-5 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'address2' class="bmd-label-floating __required">Bairro</label>
          <input name = 'address2' type = 'text' id = 'address2' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-6 col-xs-9 pl-0">
        <div class="form-group">
          <label for = 'city' class="bmd-label-floating __required">Cidade</label>
          <input name = 'city' type = 'tel' id = 'city' data-ibge = '' class = 'form-control form-control-lg' disabled/>
          <input name = '__city' type = 'hidden' id = '__city' />
        </div>
      </div>
      <div class="col-sm-1 col-xs-3 px-0">
        <div class="form-group">
          <label for = 'state' class="bmd-label-floating __required">UF</label>
          <input name = 'state' type = 'state' id = 'state' class = 'form-control form-control-lg' disabled />
        </div>
      </div>
    </div>
  </div>
</div>

@section('before_body_close')
  @include('Job::cbo-modal')
@endsection

