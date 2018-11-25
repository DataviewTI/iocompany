@extends('IntranetOne::io.layout.dashboard')

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pickadate-full.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('io/services/io-job.min.css') }}">
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

  @section('after_body_scripts')
  @endsection

@section('footer_scripts')
  <script assync defer src="{{ asset('js/optimized_cbo.js') }}" charset="ISO-8859-1"></script>
	<script src="{{ asset('js/pickadate-full.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company-mix-babel.min.js') }}"></script>
	<script src="{{ asset('io/services/io-company-mix.min.js') }}"></script>
	<script src="{{ asset('io/services/io-jobs.min.js') }}"></script>
@stop
