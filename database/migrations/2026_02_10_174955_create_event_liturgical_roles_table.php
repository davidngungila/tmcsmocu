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
        Schema::create('event_liturgical_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('parishioner_id')->nullable()->constrained('parishioners')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // For non-registered volunteers
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('parish')->nullable();
            
            // Liturgical role type
            $table->enum('role_type', [
                'priest',
                'deacon',
                'reader',
                'choir',
                'altar_server',
                'altar_preparer',
                'security',
                'hospitality',
                'usher',
                'media',
                'coordinator',
                'other'
            ])->default('other');
            
            // Schedule/Shift
            $table->foreignId('schedule_id')->nullable()->constrained('event_schedules')->onDelete('set null');
            $table->dateTime('assigned_time')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamps();
            
            $table->index(['event_id', 'role_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_liturgical_roles');
    }
};
