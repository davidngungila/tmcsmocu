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
        Schema::create('event_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('parishioner_id')->nullable()->constrained('parishioners')->onDelete('set null');
            $table->string('name')->nullable(); // For anonymous feedback
            $table->string('email')->nullable();
            $table->integer('rating')->default(5); // 1-5 stars
            $table->text('feedback');
            $table->text('suggestions')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
            
            $table->index(['event_id', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_feedbacks');
    }
};
