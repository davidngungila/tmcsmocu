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
        Schema::create('spiritual_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Choir, Legion of Mary, Charismatic Renewal
            $table->string('type'); // choir, legion, charismatic, etc.
            $table->text('description')->nullable();
            $table->string('chairperson_name')->nullable();
            $table->string('chairperson_email')->nullable();
            $table->string('chairperson_phone')->nullable();
            $table->string('deputy_chairperson_name')->nullable();
            $table->string('deputy_chairperson_email')->nullable();
            $table->string('deputy_chairperson_phone')->nullable();
            $table->string('secretary_name')->nullable();
            $table->string('secretary_email')->nullable();
            $table->string('secretary_phone')->nullable();
            $table->string('treasurer_name')->nullable();
            $table->string('treasurer_email')->nullable();
            $table->string('treasurer_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['is_active']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spiritual_groups');
    }
};
