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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->integer('reorder_quantity')->default(50);
            $table->string('unit')->default('piece'); // piece, box, kg, liter, etc.
            $table->string('supplier')->nullable();
            $table->boolean('status')->default(true); // active/inactive
            $table->string('image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('sku');
            $table->index('category');
            $table->index('status');
            $table->index('stock_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
