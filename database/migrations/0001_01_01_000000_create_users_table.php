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
            $table->id(); // Auto-increment primary key
            $table->string('user_id')->unique(); // Custom user ID, must be unique
            $table->string('name')->nullable();
            $table->string('email')->unique(); // Email should be unique
            $table->date('date_of_birth')->nullable(); // Date type for date_of_birth
            $table->date('join_date')->nullable(); // Date type for join_date
            $table->string('phone_number')->nullable();
            $table->string('status')->nullable()->index(); // Add index for frequently filtered columns
            $table->boolean('two_step')->default(false); // Use boolean for true/false values
            $table->timestamp('last_login')->nullable();
            $table->string('role_name')->nullable()->index(); // Index for role_name
            $table->string('avatar')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Non-nullable password
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
