<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('cuid');
            $table->string('cuno');
            $table->integer('organization_id');
            $table->integer('user_id');
            $table->integer('resume_id');
            $table->string('name')->nullable();
            $table->string('name_icon')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('visatype')->nullable();
            $table->string('location')->nullable();
            $table->decimal('experience', 10, 2)->nullable();
            $table->string('sex')->nullable();
            $table->string('married')->nullable();
            $table->text('education')->nullable();
            $table->text('profile_details')->nullable();
            $table->text('photo')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->tinyInteger('is_profile')->default(0);
            $table->tinyInteger('company_name_checked')->default(0);
            $table->text('role')->nullable();
            $table->text('role_category')->nullable();
            $table->text('engage_details')->nullable();
            $table->text('productivity_details')->nullable();
            $table->text('corporate_culture')->nullable();
            $table->text('strength_details')->nullable();
            $table->text('social_media_extracted')->nullable();
            $table->text('criminal_history')->nullable();
            $table->text('topinterests')->nullable();
            $table->text('traits')->nullable();
            $table->tinyInteger('data_completed')->default(0);
            $table->tinyInteger('attribution_status')->default(0);
            $table->tinyInteger('is_attribute_errror')->default(0);
            $table->tinyInteger('is_deleted_attribute')->default(0);
            $table->text('missingfields')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
