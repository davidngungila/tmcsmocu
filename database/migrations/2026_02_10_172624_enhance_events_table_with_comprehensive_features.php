<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Event categories
            $table->enum('category', ['ibada', 'mkesha', 'semina', 'mkutano_wa_vijana', 'harusi', 'mazishi', 'misa', 'event_za_kanisa', 'charity', 'hija'])->default('ibada')->after('type');
            
            // Planning fields
            $table->string('theme')->nullable()->after('title'); // Theme ya event
            $table->text('program_flow')->nullable()->after('description'); // Ratiba ya program
            $table->decimal('budget', 15, 2)->nullable()->after('expected_attendance'); // Bajeti ya event
            
            // Registration
            $table->boolean('registration_required')->default(false)->after('budget');
            $table->dateTime('registration_deadline')->nullable()->after('registration_required');
            $table->integer('max_participants')->nullable()->after('registration_deadline');
            
            // QR Code
            $table->string('qr_code')->nullable()->unique()->after('max_participants');
            
            // Status
            $table->enum('status', ['planned', 'registration_open', 'ongoing', 'completed', 'cancelled'])->default('planned')->after('is_active');
            
            // Communication
            $table->boolean('send_reminders')->default(true)->after('status');
            $table->text('announcement')->nullable()->after('send_reminders');
            
            // Media
            $table->string('cover_image')->nullable()->after('announcement');
        });
        
        // Update enum type to include all categories
        DB::statement("ALTER TABLE events MODIFY COLUMN type ENUM('misa', 'event_za_kanisa', 'charity', 'hija', 'ibada', 'mkesha', 'semina', 'mkutano_wa_vijana', 'harusi', 'mazishi') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'theme',
                'program_flow',
                'budget',
                'registration_required',
                'registration_deadline',
                'max_participants',
                'qr_code',
                'status',
                'send_reminders',
                'announcement',
                'cover_image'
            ]);
        });
    }
};
