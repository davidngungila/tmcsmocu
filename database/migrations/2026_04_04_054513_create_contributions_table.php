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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parishioner_id')->constrained()->onDelete('cascade');
            $table->foreignId('financial_year_id')->nullable()->constrained()->onDelete('set null');
            $table->string('contribution_type'); // tithe, offering, special, etc.
            $table->decimal('amount', 12, 2);
            $table->string('payment_method'); // cash, mobile_money, bank, etc.
            $table->string('transaction_reference')->nullable();
            $table->date('contribution_date');
            $table->text('description')->nullable();
            $table->string('receipt_number')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('confirmed');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes
            $table->index(['parishioner_id', 'contribution_date']);
            $table->index(['financial_year_id', 'contribution_date']);
            $table->index('contribution_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
