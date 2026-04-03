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
        Schema::create('parishioner_spiritual_group', function (Blueprint $table) {
            $table->foreignId('parishioner_id')->constrained('parishioners')->onDelete('cascade');
            $table->foreignId('spiritual_group_id')->constrained('spiritual_groups')->onDelete('cascade');
            $table->enum('role', ['member', 'leader'])->default('member');
            $table->date('joined_at')->default(now());
            $table->timestamps();
            
            $table->primary(['parishioner_id', 'spiritual_group_id']);
            $table->index(['parishioner_id']);
            $table->index(['spiritual_group_id']);
            $table->index(['role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parishioner_spiritual_group');
    }
};
