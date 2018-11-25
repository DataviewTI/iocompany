<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureJobPivotTable extends Migration
{
    public function up()
    {
        Schema::create('feature_job', function(Blueprint $table){
            $table->integer('job_id')->unsigned();
            $table->integer('feature_id')->unsigned();
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('jobs');
    }
}
