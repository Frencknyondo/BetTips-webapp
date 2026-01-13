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
        // User follows table
        Schema::create('user_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['follower_id', 'followed_id']);
        });

        // Tip ratings table
        Schema::create('tip_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tip_id')->constrained()->onDelete('cascade');
            $table->enum('rating', ['win', 'loss', 'pending'])->default('pending');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tip_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tip_ratings');
        Schema::dropIfExists('user_follows');
    }
};
