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
        Schema::create('issue_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('issue_type');
            $table->string('device_id')->nullable();
            $table->string('device_token')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('detail');
            $table->integer('status')->default(0); // 0: pending, 1:resolved
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('mobile_number');
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
        Schema::dropIfExists('issue_tokens');
    }
};
