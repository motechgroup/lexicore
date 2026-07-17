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
        Schema::create('matters', function (Blueprint $table) {
            $table->id();
            $table->string('case_number', 100)->unique();
            $table->string('title', 191);
            $table->text('description')->nullable();
            $table->foreignId('client_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('practice_area_id')->nullable()->constrained('practice_areas')->onDelete('set null');
            $table->foreignId('lead_attorney_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status', 50)->default('pending'); // pending, discovery, mediation, trial, closed, suspended
            $table->string('priority', 20)->default('medium'); // low, medium, high, critical
            $table->string('court', 191)->nullable();
            $table->string('judge', 191)->nullable();
            $table->string('opposing_party', 191)->nullable();
            $table->string('opposing_counsel', 191)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('case_value', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matters');
    }
};
