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
        Schema::create('attorney_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title', 100)->nullable(); // e.g. Managing Partner, Senior Counsel
            $table->text('bio')->nullable();
            $table->json('education')->nullable();
            $table->json('bar_admissions')->nullable();
            $table->integer('experience_years')->default(0);
            $table->json('social_links')->nullable();
            $table->string('image_path', 191)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney_profiles');
    }
};
