<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('razorpay_payment_id');
            $table->string('status');
            $table->string('payment_method');
            $table->text('description')->nullable();
            $table->text('payment_description')->nullable();
            $table->string('email');
            $table->string('contact');
            $table->string('fee');
            $table->string('tax');
            $table->string('amount');
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('plan_id');
            $table->integer('plantype_id');
            $table->string('razorpay_order_id');
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
        Schema::dropIfExists('invoices');
    }
}
