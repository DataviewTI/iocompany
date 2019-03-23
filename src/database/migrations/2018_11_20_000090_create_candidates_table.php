<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->text('name');
            $table->text('social_name')->nullable();
            $table->text('gender');
            $table->date('birthday');
            $table->char('cpf', 11)->unique();
            $table->char('cnh', 20)->nullable()->unique();
            $table->char('rg', 20)->unique();
            $table->char('zipCode',9);
            $table->text('address_street');
            $table->text('address_number');
            $table->text('address_district');
            $table->string('address_city');
            $table->text('address_state');
            $table->char('phone', 15);
            $table->char('mobile', 15);
            $table->text('email');
            $table->enum('apprentice',['S','N'])->default('N');
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('marital_status_type_id')->unsigned()->nullable();
            $table->integer('degree_id')->unsigned()->nullable();
            $table->integer('pcd_type_id')->unsigned()->nullable();
            $table->integer('pcd_group_id')->unsigned()->nullable();
            $table->integer('salary_id')->unsigned()->nullable();
            $table->integer('children_amount_id')->unsigned()->nullable();
            $table->foreign('marital_status_type_id')->references('id')->on('marital_status_types');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('pcd_type_id')->references('id')->on('pcd_types')->nullable();
            $table->foreign('pcd_group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('salary_id')->references('id')->on('salaries');
            $table->foreign('children_amount_id')->references('id')->on('children_amounts');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('address_city')->references('id')->on('cities');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
