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
        Schema::table('certificates', function (Blueprint $table) {
            $table->enum('status', ['draft', 'approved', 'revoked'])->default('approved')->after('is_verified');
            $table->timestamp('revoked_at')->nullable()->after('updated_at');
            $table->foreignId('revoked_by')->nullable()->after('revoked_at')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('revoked_at');
            $table->dropColumn('revoked_by');
        });
    }
};
