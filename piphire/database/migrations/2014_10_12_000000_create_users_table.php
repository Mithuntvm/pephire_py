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
            $table->uuid('uuid');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('is_logined')->default(0);
            $table->text('profileimage')->nullable();
            $table->integer('role_id')->default(2);
            $table->integer('organization_id')->default(0);
            $table->tinyInteger('is_manager')->default(0);
            $table->string('verification_link')->nullable();
            $table->string('twitter')->nullable();
            $table->string('location')->nullable();
            $table->string('designation')->nullable();
            $table->text('bio')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
