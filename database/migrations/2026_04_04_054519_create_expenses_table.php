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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_year_id')->nullable()->constrained()->onDelete('set null');
            $table->string('expense_category'); // utilities, maintenance, salaries, etc.
            $table->string('expense_type'); // operational, capital, emergency, etc.
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('payment_method'); // cash, bank_transfer, mobile_money
            $table->string('vendor')->nullable();
            $table->string('invoice_number')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('paid_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('receipt_attachment')->nullable(); // file path
            $table->timestamps();
            
            // Indexes
            $table->index(['financial_year_id', 'expense_date']);
            $table->index('expense_category');
            $table->index('expense_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
