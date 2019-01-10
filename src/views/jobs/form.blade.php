@php
    use Dataview\IntranetOne\IntranetOneController;
@endphp
<form action = 'job/create' id='default-form' method = 'post' class = 'form-fit'>
    @component('IntranetOne::io.components.wizard',[
      "_id" => "default-wizard",
      "_min_height"=>"400px",
      "_steps"=> [
          ["name" => "Dados da Vaga", "view"=> "Job::form-general"],
        ]
    ])
    @endcomponent
    <input type="hidden" name="has_hirer_info" value="false" id="has_hirer_info">
  </form>