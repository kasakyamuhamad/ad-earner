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
    Schema::table('ads', function (Blueprint $table) {
        $table->decimal('reward_amount', 8, 2)->default(0);
    });
}

public function down(): void
{
    Schema::table('ads', function (Blueprint $table) {
        $table->dropColumn('reward_amount');
    });
}

};
