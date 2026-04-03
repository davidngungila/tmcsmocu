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
        Schema::table('event_attendances', function (Blueprint $table) {
            $table->foreign('registration_id')
                  ->references('id')
                  ->on('event_registrations')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_attendances', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
        });
    }
};
