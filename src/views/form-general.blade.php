@php
    $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
    $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');
@endphp
<div class = 'row'>
  <div class="col-sm-3 col-12 pl-0">
    <div class="form-group">
      <label for = 'cnpj' class="bmd-label-floating __required">CNPJ</label>
      <input name = 'cnpj' type = 'text' id = 'cnpj' class = 'form-control form-control-lg' />
    </div>
  </div>
  <div class="col-sm-5 col-12">
    <div class="form-group">
      <label for = 'razaoSocial' class="bmd-label-floating __required">Razão Social</label>
      <input name = 'razaoSocial' type = 'text' id = 'razaoSocial' class = 'form-control form-control-lg' />
    </div>
  </div>
  <div class="col-sm-4 col-12 pr-0">
    <div class="form-group">
      <label for = 'nomeFantasia' class="bmd-label-floating __required">Nome Fantasia</label>
      <input name = 'nomeFantasia' type = 'text' id = 'nomeFantasia' class = 'form-control form-control-lg' />
    </div>
  </div>
</div>

<div class = 'row'>

  <div class="col-md-3 col-12">
    <div class="form-group">
      <label for = 'active' class = 'bmd-label-static d-block' style = 'font-size:14px'>Ativo?</label>
      <button type="button" style="margin-left: 40px;" class="mt-3 btn btn-lg aanjulena-btn-toggle" data-toggle="button" aria-pressed="false" data-default-state='false' autocomplete="off" name = 'active' id = 'active'>
      <div class="handle"></div>
      </button>
      <input type = 'hidden' name = '__active' id = '__active' value="false"/>
    </div>
  </div>

  @if($hasSpatie)
    <div class="col-md-3 col-12">
      <div class="form-group">
        <label for = 'recruiter' class = 'bmd-label-static d-block' style = 'font-size:14px'>Recrutador?</label>
        <button type="button" style="margin-left: 40px;" class="mt-3 btn btn-lg aanjulena-btn-toggle" data-toggle="button" aria-pressed="false" data-default-state='false' autocomplete="off" name = 'recruiter' id = 'recruiter'>
        <div class="handle"></div>
        </button>
        <input type = 'hidden' name = '__recruiter' id = '__recruiter' value="false"/>
      </div>
    </div>
  @endif

  <div class="col-sm-6 col-12 p-0">
    <div class = 'row'>
      <div class="col-sm-3 col-12">
        <div class="form-group">
          <label for = 'phone' class="bmd-label-floating __required">Telefone Fixo</label>
          <input name = 'phone' type = 'tel' id = 'phone' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-3 col-12">
        <div class="form-group">
          <label for = 'mobile' class="bmd-label-floating">Celular/WhatsApp</label>
          <input name = 'mobile' type = 'tel' id = 'mobile' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-6 col-12">
        <div class="form-group">
          <label for = 'email' class="bmd-label-floating __required">Email</label>
          <input name = 'email' type = 'email' id = 'email' class = 'form-control form-control-lg' />
        </div>
      </div>
    </div>
  </div>

</div>


<div class = 'row'>
  <div class="col-sm-7 col-12 pl-0">
    <div class = 'row'>
      <div class="col-sm-2 col-12 pr-0">
        <div class="form-group">
          <label for = 'zipCode' class="bmd-label-floating __required">CEP</label>
          <input name = 'zipCode' type = 'tel' id = 'zipCode' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-8 col-12">
        <div class="form-group">
          <label for = 'address' class="bmd-label-floating __required">Logradouro</label>
          <input name = 'address' type = 'text' id = 'address' class = 'form-control form-control-lg' />
        </div>
      </div>
      <div class="col-sm-2 col-12">
        <div class="form-group">
          <label for = 'numberApto' class="bmd-label-floating __required">Nº / Apto</label>
          <input name = 'numberApto' type = 'text' id = 'numberApto' class = 'form-control form-control-lg' />
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-5 col-12">
    <div class = 'row'>
      <div class="col-sm-5 col-12 pl-0">
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