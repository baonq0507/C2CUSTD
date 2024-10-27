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
        Schema::create('ustds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('usdt_buy_amount')->nullable();
            $table->bigInteger('usdt_sell_amount')->nullable();
            $table->bigInteger('usdt_total_amount')->nullable();
            $table->bigInteger('usdt_available_amount')->nullable();
            $table->bigInteger('usdt_min_limit')->nullable();
            $table->bigInteger('usdt_max_limit')->nullable();
            $table->bigInteger('usdt_profit')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ustds');
    }
};
