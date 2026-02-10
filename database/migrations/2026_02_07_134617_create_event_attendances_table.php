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
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('parishioner_id')->nullable()->constrained('parishioners')->onDelete('cascade');
            $table->foreignId('registration_id')->nullable()->constrained('event_registrations')->onDelete('set null');
            
            // For non-parishioner attendance
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            
            $table->boolean('attended')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->string('check_in_method')->nullable(); // qr_code, manual, online
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['event_id', 'attended']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendances');
    }
};
