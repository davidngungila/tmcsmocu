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
        Schema::create('parishioner_apostolic_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parishioner_id')->constrained('parishioners')->onDelete('cascade');
            $table->foreignId('apostolic_group_id')->constrained('apostolic_groups')->onDelete('cascade');
            $table->date('joined_date')->default(now());
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['parishioner_id', 'apostolic_group_id'], 'parishioner_apostolic_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parishioner_apostolic_group');
    }
};
