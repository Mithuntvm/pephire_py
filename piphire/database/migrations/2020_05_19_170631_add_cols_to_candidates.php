<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToCandidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->integer('notice_period')->nullable()->after('missingfields');
            $table->boolean('hasCompleted')->default(0)->after('notice_period');
            $table->boolean('attribution_retry_status')->default(0)->after('attribution_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('notice_period');
            $table->dropColumn('hasCompleted');
            $table->dropColumn('attribution_retry_status');
        });
    }
}
