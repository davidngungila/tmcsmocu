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
        Schema::table('contributions', function (Blueprint $table) {
            if (!Schema::hasColumn('contributions', 'contribution_type')) {
                $table->string('contribution_type')->after('financial_year_id');
            }
            if (!Schema::hasColumn('contributions', 'receipt_number')) {
                $table->string('receipt_number')->nullable()->after('description');
            }
            if (!Schema::hasColumn('contributions', 'status')) {
                $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('confirmed')->after('receipt_number');
            }
            if (!Schema::hasColumn('contributions', 'recorded_by')) {
                $table->unsignedBigInteger('recorded_by')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            if (Schema::hasColumn('contributions', 'contribution_type')) {
                $table->dropColumn('contribution_type');
            }
            if (Schema::hasColumn('contributions', 'recorded_by')) {
                $table->dropColumn('recorded_by');
            }
            if (Schema::hasColumn('contributions', 'receipt_number')) {
                $table->dropColumn('receipt_number');
            }
            if (Schema::hasColumn('contributions', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
