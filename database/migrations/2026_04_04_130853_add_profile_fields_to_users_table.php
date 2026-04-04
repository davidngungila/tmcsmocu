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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable();
            $table->text('bio')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('language', 10)->default('sw');
            $table->string('timezone', 50)->nullable();
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(true);
            $table->string('profile_visibility', 20)->default('public');
            $table->text('google2fa_secret')->nullable();
            $table->boolean('google2fa_enabled')->default(false);
            $table->json('google2fa_backup_codes')->nullable();
            $table->timestamp('google2fa_confirmed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
