<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function(Blueprint $table){
            $table->increments('id');
            $table->char('profile',30)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(){
        Schema::dropIfExists('profiles');
    }
}
