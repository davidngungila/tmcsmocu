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
        if (!Schema::hasTable('receipts')) {
            Schema::create('receipts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('contribution_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('parishioner_id')->constrained()->onDelete('cascade');
                $table->string('receipt_number')->unique();
                $table->decimal('amount', 12, 2);
                $table->date('receipt_date');
                $table->string('payment_method');
                $table->string('payment_status'); // paid, partial, pending
                $table->string('transaction_reference')->nullable();
                $table->text('description')->nullable();
                $table->enum('type', ['contribution', 'donation', 'special_collection'])->default('contribution');
                $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                
                // Indexes
                $table->index('receipt_number');
                $table->index(['parishioner_id', 'receipt_date']);
                $table->index('payment_status');
                $table->index('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
