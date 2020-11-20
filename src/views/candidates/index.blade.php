@extends('IntranetOne::io.layout.dashboard')

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pickadate-full.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('io/services/io-company.min.css') }}">
@stop

@section('main-heading')
@stop

@section('main-content')
	<!--section ends-->
			@component('IntranetOne::io.components.nav-tabs',
			[
				"_id" => "vj-default-tablist",
				"_active"=>0,
				"_tabs"=> [
					[
						"tab"=>"Listar",
						"icon"=>"ico ico-list",
						"view"=>"Candidate::table-list"
					],
					[
						"tab"=>"Cadastrar",
						"icon"=>"ico ico-new",
						"view"=>"Candidate::form"
					],
				]
			])
			@endcomponent
	<!-- content -->
  @stop

  	<div class="modal modal-details" tabindex="-1" role="dialog">
          <div class="modal-dialog" style="max-width: 80%" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="candidate-name"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="personal-data-tab" data-toggle="tab" href="#personal-data" role="tab" aria-controls="personal-data" aria-selected="true">Dados pessoais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Análise de perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="jobs-tab" data-toggle="tab" href="#jobs" role="tab" aria-controls="jobs" aria-selected="false">Vagas compatíveis</a>
                    </li>
                </ul>
                <div class="tab-content p-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="personal-data" role="tabpanel" aria-labelledby="personal-data-tab">
                        <div class="row">
                            <div class="col-4">
                                <p>
                                    Email:
                                    <span id="candidate-email"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Telefone:
                                    <span id="candidate-phone"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Celular:
                                    <span id="candidate-mobile"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Endereço:
                                    <span id="candidate-address-street"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Número:
                                    <span id="candidate-address-number"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    CEP:
                                    <span id="candidate-zipcode"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Bairro:
                                    <span id="candidate-address-district"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Cidade:
                                    <span id="candidate-city"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Estado:
                                    <span id="candidate-address-state"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Aprendiz:
                                    <span id="candidate-apprentice"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Data de nascimento:
                                    <span id="candidate-birthday"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Sexo:
                                    <span id="candidate-gender"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Número de filhos:
                                    <span id="candidate-children-amount"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Estado civil:
                                    <span id="candidate-marital-status"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    Pretensão salarial:
                                    <span id="candidate-salary"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    CNH:
                                    <span id="candidate-cnh"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    CPF:
                                    <span id="candidate-cpf"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    RG:
                                    <span id="candidate-rg"></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    PCD:
                                    <span id="candidate-pcd"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-12" id="evaluation">

                            </div>
                        </div>
                        <h5 style="font-weight: bold;">Respostas</h5>
                        <div class="row" id="answers">


                        </div>
                    </div>
                    <div class="tab-pane fade" id="jobs" role="tabpanel" aria-labelledby="jobs-tab">
                        <button type="button" id="fetch-jobs" class="btn btn-primary mb-2">Atualizar</button>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Cargo</th>
                                </tr>
                            </thead>
                            <tbody id="jobs-list">
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              </div>
            </div>
          </div>


	</div>

  @section('after_body_scripts')
  @endsection

@section('footer_scripts')
  <script assync defer src="{{ asset('js/optimized_cbo.js') }}" charset="ISO-8859-1"></script>
	<script src="{{ asset('js/pickadate-full.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company-mix-babel.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company-mix.min.js') }}"></script>
	<script src="{{ asset('io/services/io-candidates.min.js') }}"></script>
@stop
