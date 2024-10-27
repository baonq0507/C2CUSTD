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
        Schema::create('buy_ustds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('price_buy');
            $table->bigInteger('total_buy');
            $table->bigInteger('remaining_buy');
            $table->bigInteger('min_limit_buy');
            $table->bigInteger('max_limit_buy');
            $table->enum('status', ['pending', 'success', 'cancel']);
            $table->bigInteger('transaction_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_ustds');
    }
};
