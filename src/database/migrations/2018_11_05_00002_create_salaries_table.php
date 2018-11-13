<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    public function up()
    {
			Schema::create('salaries', function(Blueprint $table){
				$table->increments('id');
        $table->char('salary',40);
        $table->tinyInteger('order')->unsigned();        
        $table->timestamps();
        $table->softDeletes();
			});

    }

    public function down(){
        Schema::dropIfExists('salaries');
    }
}
