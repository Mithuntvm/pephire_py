<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('juid');
            $table->integer('organization_id');
            $table->integer('bulk_job_id')->nullable();
            $table->integer('user_id');
            $table->string('name');
            $table->text('description');
            $table->date('joining_date');
            $table->string('max_experience', 20);
            $table->text('location');
            $table->text('job_role');
            $table->text('job_role_category');
            $table->text('bjuid');
            $table->integer('vacant_positions');
            $table->string('offered_ctc', 20);
            $table->text('enterprise_ID')->nullable();
            $table->text('recruiter_ID')->nullable();
            $table->uiid('ruid')->nullable();

            // $table->integer('experience_min')->nullable();
            // $table->integer('experience_max')->nullable();
            // $table->string('qualification')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
