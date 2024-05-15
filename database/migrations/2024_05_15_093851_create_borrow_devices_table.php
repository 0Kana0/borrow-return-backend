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
        Schema::create('borrow_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->nullable();
            $table->string('serial_number')->nullable();
            $table->boolean('return_status')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('borrow_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_devices');
    }
};
