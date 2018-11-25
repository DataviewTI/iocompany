<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCBOTable extends Migration
{
    public function up()
    {
			Schema::create('cbo_big_groups', function(Blueprint $table){
				$table->integer('id')->unsigned();
        $table->primary('id');
        $table->string('group');
        $table->timestamps();
			});
    
			Schema::create('cbo_main_subgroups', function(Blueprint $table){
				$table->char('id',2);
        $table->primary('id');
        $table->string('subgroup');
        $table->timestamps();
			});

			Schema::create('cbo_subgroups', function(Blueprint $table){
				$table->char('id',3);
        $table->primary('id');
        $table->string('subgroup');
        $table->timestamps();
			});

			Schema::create('cbo_families', function(Blueprint $table){
				$table->char('id',4);
        $table->primary('id');
        $table->string('family');
        $table->timestamps();
			});
    
			Schema::create('cbo_occupations', function(Blueprint $table){
				$table->char('id',6);
        $table->primary('id');
        $table->string('occupation');
        $table->timestamps();
			});

			Schema::create('cbo_occupational_profiles', function(Blueprint $table){
				$table->increments('id');
        $table->char('codeBigArea',1);
        $table->string('bigArea');
        $table->smallInteger('codeActivity')->unsigned();
        $table->string('activity');
				$table->integer('id_cbo_big_group')->unsigned();
				$table->char('id_cbo_main_subgroup',2);
				$table->char('id_cbo_subgroup',3);
				$table->char('id_cbo_family',4);
				$table->char('id_cbo_occupation',6);
        $table->timestamps();

        $table->foreign('id_cbo_big_group')->references('id')->on('cbo_big_groups')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('id_cbo_main_subgroup')->references('id')->on('cbo_main_subgroups')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('id_cbo_subgroup')->references('id')->on('cbo_subgroups')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('id_cbo_family')->references('id')->on('cbo_families')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('id_cbo_occupation')->references('id')->on('cbo_occupations')->onDelete('cascade')->onUpdate('cascade');
			});

			Schema::create('cbo_synonym', function(Blueprint $table){
				$table->increments('id');
				$table->char('id_cbo_occupation',6);
        $table->string('synonymous');
        $table->timestamps();
        $table->foreign('id_cbo_occupation')->references('id')->on('cbo_occupations')->onDelete('cascade')->onUpdate('cascade');
			});
    }

    public function down(){
        Schema::dropIfExists('cbo_occupational_profiles');
        Schema::dropIfExists('cbo_synonym');
        Schema::dropIfExists('cbo_occupations');
        Schema::dropIfExists('cbo_big_groups');
        Schema::dropIfExists('cbo_main_subgroups');
        Schema::dropIfExists('cbo_subgroups');
        Schema::dropIfExists('cbo_families');
    }
}
