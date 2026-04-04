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
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['single', 'broadcast', 'scheduled']);
            $table->string('sender_id'); // Sender ID from NextSMS
            $table->string('recipient'); // Phone number
            $table->text('message');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed', 'cancelled'])->default('pending');
            $table->string('message_id')->nullable(); // Message ID from NextSMS
            $table->string('reference')->nullable(); // Reference from NextSMS
            $table->decimal('cost', 8, 2)->nullable();
            $table->integer('sms_count')->default(1);
            $table->text('error_message')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index('scheduled_at');
            $table->index('sent_at');
            $table->index('sent_by');
            $table->index('recipient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_messages');
    }
};
