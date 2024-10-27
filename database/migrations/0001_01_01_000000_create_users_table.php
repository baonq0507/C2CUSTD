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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('referral_code')->nullable();
            $table->foreignId('referral_by')->nullable()->constrained('users');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_owner')->nullable();
            $table->string('username')->nullable();
            $table->bigInteger('balance')->default(0);
            $table->bigInteger('usdt_balance')->default(0);
            $table->bigInteger('usdt_total_withdraw')->default(0);
            $table->bigInteger('usdt_total_deposit')->default(0);
            $table->bigInteger('total_withdraw')->default(0);
            $table->bigInteger('total_deposit')->default(0);
            $table->boolean('accept_info')->default(false);
            $table->integer('level')->default(1);
            $table->string('cccd_before')->nullable();
            $table->string('cccd_after')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
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
