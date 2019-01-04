<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function(Blueprint $table){
            $table->increments('id');
            $table->char('company_id',14);
            $table->integer('profile_id')->unsigned();
            $table->char('cbo_occupation_id',6);
            $table->date('date_start');
            $table->date('date_end');
            $table->smallInteger('interval')->unsigned();
            $table->integer('degree_id')->unsigned();
            $table->enum('gender',['I','M','F'])->default('I');
            $table->enum('apprentice',['S','N'])->default('N');
            $table->longText('hirer_info');
            $table->integer('pcd_type_id')->unsigned()->nullable();
            $table->integer('salary_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pcd_type_id')->references('id')->on('pcd_types')->nullable();
             $table->foreign('company_id')->references('cnpj')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cbo_occupation_id')->references('id')->on('cbo_occupations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('salary_id')->references('id')->on('salaries')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('jobs');
    }
}
