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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method'); // cash, card, mobile_money, etc.
            $table->string('payment_status')->default('pending'); // paid, partial, pending
            $table->string('status')->default('pending'); // pending, completed, cancelled, refunded
            $table->text('notes')->nullable();
            $table->foreignId('sold_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('sale_date')->default(now());
            $table->timestamps();
            
            // Indexes
            $table->index('receipt_number');
            $table->index('sale_date');
            $table->index('payment_method');
            $table->index('payment_status');
            $table->index('status');
            $table->index('sold_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
