<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendents', function (Blueprint $table) {
            $table->id();
            $table->string('license_number');
            $table->string('aprt_number');
            $table->string('passcode');
            $table->string('start_time');
            $table->string('start_time');
            $table->string('vehicle_details');
            $table->string('neme');
            $table->string('email');
            $table->string('phone');
            $table->string('type');
            $table ->string('notify');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendents');
    }
};
