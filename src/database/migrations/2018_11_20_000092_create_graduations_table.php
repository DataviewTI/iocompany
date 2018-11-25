<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id')->unsigned()->nullable();
            $table->integer('graduation_type_id')->unsigned()->nullable();
            $table->text('institution');
            $table->text('school');
            $table->year('ending');
            $table->tinyInteger('order')->unsigned();        
            $table->timestamps();
            $table->foreign('candidate_id')->references('id')->on('candidates');
            $table->foreign('graduation_type_id')->references('id')->on('graduation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graduations');
    }
}
