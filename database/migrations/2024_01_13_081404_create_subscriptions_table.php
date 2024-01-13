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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('subs_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('txn_id')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ends_on')->nullable();
            $table->string('validity_days', 256)->nullable();
            $table->unsignedBigInteger('status')->default(2);
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
        Schema::dropIfExists('subscriptions');
    }
};
