<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBnbUsersTable extends Migration
{
    public function up()
    {
        Schema::create('bnb_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('useremail')->nullable();
            $table->string('profileimage')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->enum('status', ['active', 'unactive'])->default('active');
            $table->enum('role', ['bnbadmin','bnbowner','bnbreceiptionist','bnbsecurity','bnbchef'])->default('bnbowner');
            $table->string('createdby')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bnb_users');
    }
}
