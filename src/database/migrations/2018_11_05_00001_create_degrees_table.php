<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDegreesTable extends Migration
{
    public function up()
    {
			Schema::create('degrees', function(Blueprint $table){
				$table->increments('id');
        $table->char('degree',40);
        $table->tinyInteger('order')->unsigned();        
        $table->timestamps();
        $table->softDeletes();
			});

    }

    public function down(){
        Schema::dropIfExists('degrees');
    }
}
