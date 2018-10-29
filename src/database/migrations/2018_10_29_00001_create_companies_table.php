<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
			Schema::create('companies', function(Blueprint $table)
			{
				$table->char('cnpj',14);
				$table->char('razaoSocial',50);
				$table->char('nomeFantasia',50);
        $table->char('inscEstadual', 20)->nullable();
        $table->char('telefone1', 15)->nullable();
        $table->char('telefone2', 15)->nullable();
        $table->char('celular1',15)->nullable();
        $table->char('celular2',15)->nullable();
        $table->string('email')->nullable();
        $table->char('cep',9)->nullable();
        $table->string('logradouro')->nullable();
        $table->char('numero',20)->nullable();
        $table->string('complemento')->nullable();
        $table->string('bairro')->nullable();
        $table->integer('city_id')->unsigned();
        $table->integer('group_id')->unsigned()->nullable();
				$table->string('description')->nullable();
				$table->text('data')->nullable();
        $table->timestamps();
				$table->softDeletes();
        $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
