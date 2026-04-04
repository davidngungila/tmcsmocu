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
        if (!Schema::hasTable('contributions')) {
            Schema::create('contributions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parishioner_id');
                $table->unsignedBigInteger('financial_year_id');
                $table->decimal('amount', 12, 2);
                $table->date('contribution_date');
                $table->string('payment_method');
                $table->string('payment_status')->default('pending');
                $table->string('transaction_reference')->nullable();
                $table->text('description')->nullable();
                $table->enum('type', ['sadaka', 'zaka', 'fungu_la_kumi', 'shukrani', 'michango_mingine'])->default('sadaka');
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
                
                // Indexes
                $table->index(['parishioner_id', 'contribution_date']);
                $table->index('financial_year_id');
                $table->index('payment_status');
                $table->index('type');
                $table->index('contribution_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
