<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('email')->unique();
            $table->string('provider');
            $table->string('provider_id');
            $table->string('avatar_url');
            $table->string('access_token');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->unique(['username', 'provider']);
            $table->unique(['provider', 'provider_id']);
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
