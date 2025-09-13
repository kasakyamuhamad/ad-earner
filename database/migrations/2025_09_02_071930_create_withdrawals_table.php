<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('withdrawals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->integer('amount');
        $table->string('phone'); // Mobile money number
        $table->string('network')->default('MTN'); // MTN, Airtel, etc
        $table->string('status')->default('pending'); // pending/approved/rejected
        $table->text('reason')->nullable(); // Reason for rejection
        $table->string('transaction_id')->nullable(); // Flutterwave transaction ID
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
