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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('amount');
            $table->enum('type', ['deposit', 'withdraw', 'deposit_ustd', 'buy_usdt', 'sell_usdt']);
            $table->foreignId('deposit_ustd_id')->nullable()->constrained('deposit_ustds');
            $table->foreignId('ustd_id')->nullable()->constrained('ustds');
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
