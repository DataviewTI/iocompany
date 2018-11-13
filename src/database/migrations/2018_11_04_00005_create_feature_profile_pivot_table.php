<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureProfilePivotTable extends Migration
{
    public function up()
    {
			Schema::create('feature_profile', function(Blueprint $table){
        $table->integer('profile_id')->unsigned();
        $table->integer('feature_id')->unsigned();
        $table->timestamps();
        $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade')->onUpdate('cascade');
			});
    }

    public function down(){
        Schema::dropIfExists('feature_profile');
    }
}
