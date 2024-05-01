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
        Schema::create('sim_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->string('device_id')->nullable();
            $table->string('operator');
            $table->string('area');
            $table->string('strength')->nullable();
            $table->string('phone_number');
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
        Schema::dropIfExists('sim_details');
    }
};
