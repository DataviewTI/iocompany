<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('company_cnpj',14);
            $table->integer('plan_id')->unsigned();
            $table->enum('payment_method', ['CREDIT_CARD', 'BOLETO', 'ALL'])->nullable();
            $table->integer('max_portions');
            $table->longText('wirecard_data')->nullable();

            $table->foreign('company_cnpj')->references('cnpj')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade')->onUpdate('cascade');
            
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
