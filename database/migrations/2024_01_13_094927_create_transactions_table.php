<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('t_id');
            $table->string('txn_id', 256)->unique()->nullable();

            $table->integer('client_id');

            $table->string('txn_type', 256)->nullable();
            $table->string('txn_mode', 256);
            $table->string('net_amount', 256);
            $table->string('tax_amt', 256)->default(0)->nullable();
            $table->string('price', 256);
            $table->string('discount_amt', 256)->default(0);
            $table->string('paid_amt', 256);
            $table->string('plan_validity_days', 256);

            $table->integer('package_id')->nullable();
            $table->string('package_name', 256)->nullable();

            $table->integer('activation_id')->nullable();
            $table->string('activation_code', 256)->nullable();

            $table->integer('coupon_id')->nullable();
            $table->string('coupon_code', 256)->nullable();

            $table->string('razorpay_order_id')->nullable();
            $table->string('redirected')->default(false);
            $table->string('razorpay_payment_id')->nullable();
            $table->unsignedBigInteger('status')->default(1); //2 for success
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
