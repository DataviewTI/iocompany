<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->string('description')->nullable();
            $table->decimal('amount', 8, 2);
            $table->decimal('setup_fee', 8, 2)->nullable();
            $table->enum('interval_unit', ['DAY', 'MONTH', 'YEAR'])->default('MONTH');
            $table->integer('interval_length')->default(1);
            $table->integer('billing_cycles')->nullable();
            $table->integer('trial_days')->nullable();
            $table->boolean('trial_enabled')->nullable();
            $table->boolean('trial_hold_setup_fee')->nullable();
            $table->boolean('status')->default(TRUE);
            $table->integer('max_qty')->nullable();
            $table->enum('payment_method', ['CREDIT_CARD', 'BOLETO', 'ALL'])->defaul('ALL');

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
        Schema::dropIfExists('plans');
    }
}
