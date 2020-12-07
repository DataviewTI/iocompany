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
				"_id" => "default-tablist",
				"_active"=>0,
				"_tabs"=> [
					[
						"tab"=>"Listar",
						"icon"=>"ico ico-list",
						"view"=>"Company::table-list"
					],
					[
						"tab"=>"Cadastrar",
						"icon"=>"ico ico-new",
						"view"=>"Company::form"
					],
					[
						"tab"=>"Pagamentos",
						"icon"=>"ico ico-money",
						"view"=>"Company::orders"
					],
				]
			])
			@endcomponent
	<!-- content -->
  @stop

  @section('after_body_scripts')
  @endsection

@section('footer_scripts')
    <script src="{{ asset('js/pickadate-full.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company-mix-babel.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company-mix.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company.min.js') }}"></script>
@stop
