<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_timeslots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('user_id');
            $table->string('interviewer_name');
            $table->string('email');
            $table->string('contact_number', 20);
            $table->date('interview_date');
            $table->string('interview_start_time', 10);
            $table->string('interview_end_time', 10);
            $table->boolean('hasAllotted')->default(0);
            $table->unsignedBigInteger('allotted_candidate_id')->nullable();
            $table->timestamps();
        });

        /**
         * Foreign Key Constraint
         */
        Schema::table('interview_timeslots', function (Blueprint $table) {
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('allotted_candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_timeslots');
    }
}
