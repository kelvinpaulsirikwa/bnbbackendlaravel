<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotelTypesTable extends Migration
{
    public function up()
    {
        Schema::create('motel_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('createby')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motel_types');
    }
}
