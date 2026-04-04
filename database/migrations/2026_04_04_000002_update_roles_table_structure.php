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
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['permissions']);
            $table->string('display_name')->nullable()->after('name');
            $table->string('level')->default('standard')->after('description'); // super_admin, leadership, standard, limited
            $table->boolean('is_active')->default(true)->after('level');
            $table->text('responsibilities')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->json('permissions')->nullable();
            $table->dropColumn(['display_name', 'level', 'is_active', 'responsibilities']);
        });
    }
};
