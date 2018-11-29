<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id')->unsigned()->nullable();
            $table->integer('job_duration_id')->unsigned()->nullable();
            $table->integer('resignation_reason_id')->unsigned()->nullable();
            $table->enum('type', ['J', 'V'])->default('V');
            $table->text('company');
            $table->text('role');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('job_duration_id')->references('id')->on('job_durations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('resignation_reason_id')->references('id')->on('resignation_reasons')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_experiences');
    }
}
