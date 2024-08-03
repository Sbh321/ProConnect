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
        Schema::create('followers', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade'); // User who is following
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade'); // User being followed
            $table->timestamps();

            // Add unique constraint to ensure a follower can only follow a person once
            $table->unique(['follower_id', 'following_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
