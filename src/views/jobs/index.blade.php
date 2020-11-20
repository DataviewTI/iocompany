@extends('IntranetOne::io.layout.dashboard')

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pickadate-full.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('io/services/io-jobs.min.css') }}">
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
						"view"=>"Job::table-list"
					],
					[
						"tab"=>"Cadastrar",
						"icon"=>"ico ico-new",
						"view"=>"Job::form"
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
                    <a class="nav-link active" id="job-info-tab" data-toggle="tab" href="#job-info" role="tab" aria-controls="job-info" aria-selected="true">Detalhes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="candidates-tab" data-toggle="tab" href="#candidates" role="tab" aria-controls="candidates" aria-selected="false">Candidatos compatíveis</a>
                </li>
            </ul>
            <div class="tab-content p-2" id="myTabContent">
                <div class="tab-pane fade show active" id="job-info" role="tabpanel" aria-labelledby="job-info-tab">
                    <div class="row">
                        <div class="col-4">
                            <p>
                                Empresa:
                                <span id="job-company"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                Perfil da vaga:
                                <span id="job-profile"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                CBO:
                                <span id="job-cbo-occupation"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                Escolaridade mínima:
                                <span id="job-degree"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                Sexo:
                                <span id="job-gender"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                Aprendiz:
                                <span id="job-apprentice"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                PCD:
                                <span id="job-pcd"></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                Valor do salário:
                                <span id="job-salary"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="candidates" role="tabpanel" aria-labelledby="candidates-tab">
                    <button type="button" id="fetch-candidates" class="btn btn-primary mb-2">Atualizar</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Perfil</th>
                            </tr>
                        </thead>
                        <tbody id="candidates-list">
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
	<script src="{{ asset('io/services/io-jobs-mix-babel.min.js') }}"></script>
	<script src="{{ asset('io/services/io-jobs-mix.min.js') }}"></script>
	<script src="{{ asset('io/services/io-jobs.min.js') }}"></script>
@stop
