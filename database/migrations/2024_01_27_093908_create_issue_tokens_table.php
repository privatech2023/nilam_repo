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
            $table->string('name');
            $table->string('device_id');
            $table->string('device_token');
            $table->integer('client_id');
            $table->string('detail');
            $table->integer('status')->default(0); // 0: pending, 1:resolved
            $table->date('start-date');
            $table->date('end-date')->nullable();
            $table->string('mobile_number');
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
        Schema::dropIfExists('issue_tokens');
    }
};
