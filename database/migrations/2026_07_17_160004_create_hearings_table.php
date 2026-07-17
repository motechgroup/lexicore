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
        Schema::create('hearings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matter_id')->constrained('matters')->onDelete('cascade');
            $table->string('title', 191);
            $table->dateTime('hearing_date');
            $table->string('location', 191)->nullable(); // e.g. Superior Court Room 402, Zoom
            $table->text('notes')->nullable();
            $table->string('status', 50)->default('scheduled'); // scheduled, completed, cancelled, postponed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hearings');
    }
};
