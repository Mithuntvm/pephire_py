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
            $table->bigIncrements('id');
            $table->uuid('puid');
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->integer('plantype_id');
            $table->integer('no_of_searches');
            $table->integer('max_users');
            $table->integer('max_resume_count')->default(25);
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('year_count')->default(0);
            $table->integer('month_count')->default(0);
            $table->tinyInteger('frontend_show')->default(0);         
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
