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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('parishioner_id')->nullable()->constrained('parishioners')->onDelete('cascade');
            
            // For non-parishioner registrations
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            
            // Participant type
            $table->enum('participant_type', ['regular_member', 'youth', 'choir', 'guest', 'minister', 'usher', 'media', 'security', 'protocol'])->default('regular_member');
            
            // Registration details
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->text('special_requirements')->nullable();
            $table->string('qr_code')->nullable()->unique();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('confirmed_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['event_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
