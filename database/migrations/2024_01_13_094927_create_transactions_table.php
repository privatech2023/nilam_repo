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
            $table->string('txn_id', 256)->unique();
            $table->unsignedBigInteger('client_id');
            $table->string('txn_type', 256);
            $table->string('txn_mode', 256);
            $table->string('net_amount', 256);
            $table->string('tax_amt', 256)->default(0);
            $table->string('price', 256);
            $table->string('discount_amt', 256)->default(0);
            $table->string('paid_amt', 256);
            $table->string('plan_validity_days', 256);
            $table->string('package_name', 256)->nullable();
            $table->string('activation_code', 256)->nullable();
            $table->string('coupon_code', 256)->nullable();
            $table->unsignedBigInteger('status')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
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
