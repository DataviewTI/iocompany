<div class = 'row dt-filters-container mb-2'>
	<div class="col-6">
		<div class="form-group">
            {{-- <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i> Palavra Chave</label>
            <input type = 'text' class = 'form-control form-control-lg' name ='ft_search' id = 'ft_search' /> --}}
		</div>
    </div>
    <div class="col-6 d-flex justify-content-end align-items-center">
        <button class="btn btn-primary" id="open-orders-modal"><i class="ico ico-plus"></i> Criar pagamento</button>
	</div>
</div>
@php
	$pkg = json_decode(file_get_contents(base_path('composer.json')),true);
	$hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');  
@endphp
@component('IntranetOne::io.components.datatable',[
    "_id" => "orders-table",
    "_columns"=> [
            ["title" => "Id"],
            ["title" => "CNPJ"],
            ["title" => "Razão Social"],
            ["title" => "Email"],
            ["title" => "Plano"],
            ["title" => "Valor"],
            ["title" => "Status"],
            ["title" => "Dt Pagamento"],
            ["title" => "Ações"],
        ]
    ])
@endcomponent	

@php
    $plans = Dataview\IOCompany\Plan::all();
    $companies = Dataview\IOCompany\Company::all();
    $token = base64_encode(config('wirecard.token').':'.config('wirecard.key'));
@endphp
<script>
    var token = @php echo json_encode($token); @endphp 
</script>
<div id="order-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="order-form">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">CNPJ</label>
                        <select class="custom-select" name="company" id="company">
                            {{-- <option value="" selected></option> --}}
                            @foreach ($companies as $company)
                                <option value="{{ $company }}">{{ $company->cnpj }} - {{ $company->razaoSocial }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Plano</label>
                        <select class="custom-select" name="plan" id="plan">
                            {{-- <option value="" selected></option> --}}
                            @foreach ($plans as $plan)
                                <option value="{{ $plan }}">{{ $plan->name }} - R$ {{ $plan->amount }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Forma de pagamento</label>
                            <div class="form-check">
                                <input checked class="form-check-input" type="checkbox" value="" name="credit_card" id="credit_card">
                                <label class="form-check-label" for="defaultCheck1">
                                    Cartão de crédito
                                </label>
                            </div>
                            <div class="form-check">
                                <input checked class="form-check-input" type="checkbox" value="" name="boleto" id="boleto">
                                <label class="form-check-label" for="defaultCheck1">
                                    Boleto
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Número máximo de parcelas</label>
                            <select class="custom-select" name="max_portions" id="max_portions">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="create-order">Criar</button>
            </div>
        </div>
    </div>
</div>