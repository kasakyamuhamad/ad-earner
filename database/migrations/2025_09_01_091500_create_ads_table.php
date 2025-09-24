<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('image'); // 'image', 'video', 'html'
            $table->string('content_url')->nullable(); // URL to image/video
            $table->string('target_url')->nullable(); // click destination
            $table->decimal('reward_amount', 8, 2)->default(0);
            $table->integer('view_duration')->default(30); // seconds user must watch
            $table->integer('cooldown_minutes')->default(60); // user cooldown before next view
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('max_views')->nullable(); // optional max views
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
