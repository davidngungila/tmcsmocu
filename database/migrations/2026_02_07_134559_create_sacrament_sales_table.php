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
        Schema::create('sacrament_sales', function (Blueprint $table) {
            $table->id();
            $table->enum('sacrament_type', ['ubatizo', 'kipaimara', 'ndoa', 'misa_maalum']);
            $table->string('customer_name');
            $table->string('phone')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('sale_date');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sacrament_sales');
    }
};
