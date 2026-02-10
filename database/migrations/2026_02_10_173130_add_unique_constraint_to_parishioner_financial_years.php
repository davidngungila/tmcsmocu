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
        // Check if table exists and add unique constraint if it doesn't exist
        if (Schema::hasTable('parishioner_financial_years')) {
            // Check if constraint already exists
            $constraintExists = DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.table_constraints 
                WHERE constraint_schema = DATABASE() 
                AND table_name = 'parishioner_financial_years' 
                AND constraint_name = 'parishioner_fy_unique'
            ");
            
            if ($constraintExists[0]->count == 0) {
                Schema::table('parishioner_financial_years', function (Blueprint $table) {
                    $table->unique(['parishioner_id', 'financial_year_id'], 'parishioner_fy_unique');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parishioner_financial_years', function (Blueprint $table) {
            $table->dropUnique('parishioner_fy_unique');
        });
    }
};
