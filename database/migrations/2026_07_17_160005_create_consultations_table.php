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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name', 191);
            $table->string('email', 191);
            $table->string('phone', 50)->nullable();
            $table->dateTime('appointment_date');
            $table->text('notes')->nullable();
            $table->string('status', 50)->default('pending'); // pending, approved, completed, cancelled
            $table->foreignId('assigned_attorney_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
