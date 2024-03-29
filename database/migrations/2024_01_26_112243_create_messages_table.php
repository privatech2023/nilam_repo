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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->string('device_id');
            $table->bigInteger('message_id')->index();
            $table->string('number');
            $table->dateTime('date');
            $table->text('body');
            $table->boolean('is_inbox'); // 1 = inbox, 0 = sent
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
        Schema::dropIfExists('messages');
    }
};
