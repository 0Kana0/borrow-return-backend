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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->nullable();
            $table->string('brand')->nullable();
            $table->date('warrantyexpirationdate')->nullable();
            $table->string('fullbatterycapacity')->nullable();
            $table->string('currentbatterycapacity')->nullable();
            $table->string('diskperformance')->nullable();
            $table->date('fullbatterycapacitydate')->nullable();
            $table->date('currentbatterycapacitydate')->nullable();
            $table->date('diskperformancedate')->nullable();
            $table->string('spec')->nullable();
            $table->string('status')->nullable();
            $table->string('picture', 300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
