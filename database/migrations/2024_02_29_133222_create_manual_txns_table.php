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
        Schema::create('manual_txns', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('txn_id');
            $table->integer('devices');
            $table->integer('storage');
            $table->string('storage_validity');
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
        Schema::dropIfExists('manual_txns');
    }
};
