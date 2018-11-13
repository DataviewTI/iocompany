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
        $table->primary('cnpj');
        $table->char('razaoSocial',50);
				$table->char('nomeFantasia',50);
        $table->char('inscEstadual', 20)->nullable();
        $table->char('phone', 15)->nullable();
        $table->char('phone2', 15)->nullable();
        $table->char('mobile',15)->nullable();
        $table->char('mobile2',15)->nullable();
        $table->string('email')->nullable();
        $table->char('zipCode',9);
        $table->string('address');
        $table->string('address2')->nullable();
        $table->char('numberApto',20);
        $table->char('city_id',7);
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
