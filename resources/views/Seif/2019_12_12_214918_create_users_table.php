<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('privilage');
            $table->string('email');
            $table->string('username');
            $table->unique(['username']);
            $table->unique(['email']);
            $table->string('password');
            $table->string('fname');
            $table->string('lname');
            $table->char('gender', 1); //** F or M
            $table->string('city');
            $table->string('address')->nullable();
            $table->date('Bdate');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
