<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify enum to include 'shukrani'
        DB::statement("ALTER TABLE finance_transactions MODIFY COLUMN category ENUM('zaka', 'sadaka', 'fungu_la_kumi', 'shukrani', 'michango_mingine', 'matumizi') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'shukrani' from enum
        DB::statement("ALTER TABLE finance_transactions MODIFY COLUMN category ENUM('zaka', 'sadaka', 'fungu_la_kumi', 'michango_mingine', 'matumizi') NOT NULL");
    }
};
