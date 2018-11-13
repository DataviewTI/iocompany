<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCNAETable extends Migration
{
    public function up()
    {
			Schema::create('cnae', function(Blueprint $table){
				$table->char('id',10);
        $table->primary('id');
        $table->string('description');
        $table->timestamps();
			});
    }

    public function down(){
        Schema::dropIfExists('cnae');
    }
}
