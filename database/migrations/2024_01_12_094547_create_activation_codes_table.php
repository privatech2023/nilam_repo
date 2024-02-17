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
        Schema::create('activation_codes', function (Blueprint $table) {
            $table->id('c_id');
            $table->string('code', 256);
            $table->string('duration_in_days', 256);
            $table->string('net_amount', 256);
            $table->string('tax', 256)->default(0);
            $table->string('price', 256);
            $table->integer('is_active')->default(1);
            $table->unsignedBigInteger('used_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->date('expiry_date');
            $table->integer('devices')->default(1);
            $table->timestamps();


            $table->index(['code', 'is_active']);

            $table->foreign('used_by')->references('client_id')->on('clients')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activation_codes');
    }
};
