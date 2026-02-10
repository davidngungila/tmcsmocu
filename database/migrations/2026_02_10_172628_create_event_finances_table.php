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
        Schema::create('event_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->enum('type', ['income', 'expense'])->default('income');
            $table->enum('category', ['sadaka', 'ahadi', 'donation', 'mchango', 'matumizi', 'transport', 'catering', 'venue', 'equipment', 'other'])->default('other');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->foreignId('parishioner_id')->nullable()->constrained('parishioners')->onDelete('set null');
            $table->string('payment_method')->nullable(); // cash, mpesa, tigopesa, airtel, bank
            $table->string('reference_number')->nullable();
            $table->date('transaction_date');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['event_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_finances');
    }
};
