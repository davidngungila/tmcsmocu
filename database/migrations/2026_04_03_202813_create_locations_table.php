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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('region', 100);
            $table->string('region_code', 10);
            $table->string('district', 100);
            $table->string('district_code', 10);
            $table->string('ward', 100);
            $table->string('ward_code', 10);
            $table->string('street', 100)->nullable();
            $table->string('place', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['region', 'district', 'ward']);
            $table->index(['region_code']);
            $table->index(['district_code']);
            $table->index(['ward_code']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
