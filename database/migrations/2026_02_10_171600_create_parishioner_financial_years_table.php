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
        if (!Schema::hasTable('parishioner_financial_years')) {
            Schema::create('parishioner_financial_years', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parishioner_id')->constrained('parishioners')->onDelete('cascade');
                $table->foreignId('financial_year_id')->constrained('financial_years')->onDelete('cascade');
                $table->enum('status', ['new', 'active', 'graduated'])->default('new');
                $table->date('joined_date')->nullable();
                $table->date('graduated_date')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->unique(['parishioner_id', 'financial_year_id'], 'parishioner_fy_unique');
            });
        } else {
            // Table exists, just add unique constraint if it doesn't exist
            Schema::table('parishioner_financial_years', function (Blueprint $table) {
                if (!$this->constraintExists('parishioner_financial_years', 'parishioner_fy_unique')) {
                    $table->unique(['parishioner_id', 'financial_year_id'], 'parishioner_fy_unique');
                }
            });
        }
    }
    
    private function constraintExists($table, $constraint)
    {
        $constraints = \DB::select("
            SELECT constraint_name 
            FROM information_schema.table_constraints 
            WHERE constraint_schema = DATABASE() 
            AND table_name = ? 
            AND constraint_name = ?
        ", [$table, $constraint]);
        
        return count($constraints) > 0;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parishioner_financial_years');
    }
};
