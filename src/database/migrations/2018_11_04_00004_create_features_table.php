<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    public function up()
    {
			Schema::create('features', function(Blueprint $table){
				$table->increments('id');
        $table->char('feature',30)->unique();
        $table->timestamps();
        $table->softDeletes();
			});
    }

    public function down(){
        Schema::dropIfExists('features');
    }
}
