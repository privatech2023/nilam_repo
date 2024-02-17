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
        Schema::create('screen_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->string('device_id');
            $table->string('filename');
            $table->string('size');
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
        Schema::dropIfExists('screen_recordings');
    }
};
