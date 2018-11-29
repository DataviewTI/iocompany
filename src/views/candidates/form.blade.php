@php
    use Dataview\IntranetOne\IntranetOneController;
@endphp
<form action = 'candidate/create' id='default-form' method = 'post' class = 'form-fit'>
    @component('IntranetOne::io.components.wizard',[
      "_id" => "default-wizard",
      "_min_height"=>"400px",
      "_steps"=> [
            ["name" => "Dados pessoais", "view"=> "Candidate::form-general"],
            ["name" => "Experiência profissional", "view"=> "Candidate::form-experience"],
        ]
    ])
    @endcomponent
  </form>