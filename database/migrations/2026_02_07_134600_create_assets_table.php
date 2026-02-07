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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['majengo', 'vifaa', 'samani', 'vifaa_vya_ibada', 'nyingine']);
            $table->text('description')->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->date('acquisition_date')->nullable();
            $table->enum('status', ['inayotumika', 'iliyoharibika', 'inayohitaji_matengenezo', 'imepotea']);
            $table->text('location')->nullable();
            $table->text('maintenance_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
