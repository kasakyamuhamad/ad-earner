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
        // database/migrations/xxxx_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('phone')->unique();
    $table->integer('balance')->default(0);
    $table->timestamp('last_ad_view')->nullable();
    $table->rememberToken();
    $table->timestamps();
});

// database/migrations/xxxx_create_ads_table.php
Schema::create('ads', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('embed_code'); // AdSense/HTML
    $table->integer('payout');
    $table->timestamps();
});

// database/migrations/xxxx_xx_xx_create_ads_table.php
Schema::create('ads', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('embed_code'); // Google AdSense or custom HTML
    $table->integer('payout'); // Coins per view
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
