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
        Schema::create('test_subs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('package_id')->nullable();
            $table->string('package_name')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_promoter_name')->nullable();
            $table->integer('activation_code_id')->nullable();
            $table->string('activation_code')->nullable();
            $table->integer('plan_net_amount');
            $table->integer('plan_tax')->default(0);
            $table->dateTime('started_at');
            $table->dateTime('expires_at');
            $table->integer('duration_in_days');
            $table->integer('gross_price');
            $table->integer('discount_amount')->default(0);
            $table->integer('net_amount');
            $table->integer('tax')->default(0);
            $table->integer('price');
            $table->string('payment_method');
            $table->string('status');
            $table->timestamps();
            $table->integer('payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_subs');
    }
};
