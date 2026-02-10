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
            // Catholic-specific fields - check if columns exist first
            if (!Schema::hasColumn('events', 'parish')) {
                $table->string('parish')->nullable()->after('location'); // Parish/Parish
            }
            if (!Schema::hasColumn('events', 'priest_name')) {
                $table->string('priest_name')->nullable()->after('parish'); // Priest/Bishop name
            }
            if (!Schema::hasColumn('events', 'liturgical_color')) {
                $table->string('liturgical_color')->nullable()->after('priest_name'); // Liturgical color
            }
            if (!Schema::hasColumn('events', 'spiritual_theme')) {
                $table->text('spiritual_theme')->nullable()->after('theme'); // Spiritual theme
            }
            if (!Schema::hasColumn('events', 'scripture_readings')) {
                $table->text('scripture_readings')->nullable()->after('spiritual_theme'); // Scripture readings
            }
            if (!Schema::hasColumn('events', 'community')) {
                $table->string('community')->nullable()->after('parish'); // Community involved
            }
            if (!Schema::hasColumn('events', 'requires_approval')) {
                $table->boolean('requires_approval')->default(false)->after('registration_required');
            }
            if (!Schema::hasColumn('events', 'approval_level')) {
                $table->enum('approval_level', ['parish_coordinator', 'pastor', 'diocese'])->nullable()->after('requires_approval');
            }
        });
        
        // Update event types to include Catholic events (removing duplicates)
        DB::statement("ALTER TABLE events MODIFY COLUMN type ENUM('misa_ya_kawaida', 'misa_maalum', 'harusi', 'mazishi', 'kipaimara', 'novena', 'adoration', 'ekaristi_takatifu', 'kwaresima', 'kipindi_cha_pasaka', 'mikutano_ya_jumuiya', 'semina', 'retreata', 'matukio_ya_dayosisi', 'misa', 'event_za_kanisa', 'charity', 'hija', 'ibada', 'mkesha', 'mkutano_wa_vijana') NOT NULL");
        
        DB::statement("ALTER TABLE events MODIFY COLUMN category ENUM('misa_ya_kawaida', 'misa_maalum', 'harusi', 'mazishi', 'kipaimara', 'novena', 'adoration', 'ekaristi_takatifu', 'kwaresima', 'kipindi_cha_pasaka', 'mikutano_ya_jumuiya', 'semina', 'retreata', 'matukio_ya_dayosisi', 'ibada', 'mkesha', 'mkutano_wa_vijana', 'misa', 'event_za_kanisa', 'charity', 'hija') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'parish',
                'priest_name',
                'liturgical_color',
                'spiritual_theme',
                'scripture_readings',
                'community',
                'requires_approval',
                'approval_level'
            ]);
        });
    }
};
