<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToInterviewTimeslots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview_timeslots', function (Blueprint $table) {
            $table->text('meeting_details')->nullable()->after('interview_end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interview_timeslots', function (Blueprint $table) {
            $table->dropColumn('meeting_details');
        });
    }
}
