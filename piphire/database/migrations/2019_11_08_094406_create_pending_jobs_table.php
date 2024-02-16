<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organization_id');
            $table->integer('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('max_experience', 20)->nullable();
            $table->text('location')->nullable();
            $table->text('job_role')->nullable();
            $table->text('job_role_category')->nullable();
            $table->string('offered_ctc', 20)->nullable();
            $table->tinyInteger('is_recoment')->default(0);
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
        Schema::dropIfExists('pending_jobs');
    }
}
