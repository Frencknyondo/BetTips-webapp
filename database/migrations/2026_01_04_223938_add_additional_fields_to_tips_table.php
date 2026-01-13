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
        Schema::table('tips', function (Blueprint $table) {
            $table->string('company')->nullable()->after('title');
            $table->string('bet_code')->nullable()->after('company');
            $table->decimal('odds', 8, 2)->nullable()->after('bet_code');
            $table->integer('stake')->nullable()->after('odds');
            $table->enum('tip_type', ['free', 'locked', 'premium'])->default('free')->after('stake');
            $table->decimal('price', 10, 2)->nullable()->after('tip_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['company', 'bet_code', 'odds', 'stake', 'tip_type', 'price']);
        });
    }
};
