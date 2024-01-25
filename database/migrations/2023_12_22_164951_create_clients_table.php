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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('name');
            $table->string('email')->nullable();;
            $table->text('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile_number')->unique();
            $table->string('otp')->nullable();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->string('device_name')->nullable();
            $table->string('device_id')->nullable();
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('clients');
    }
};
