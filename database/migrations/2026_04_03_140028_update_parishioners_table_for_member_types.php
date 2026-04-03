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
        Schema::table('parishioners', function (Blueprint $table) {
            // Add member type column
            $table->enum('member_type', ['student', 'employee', 'child'])->default('student')->after('id');
            
            // Student specific fields
            $table->string('registration_number')->nullable()->after('member_type');
            $table->string('academic_programme')->nullable()->after('registration_number');
            $table->integer('year_of_study')->nullable()->after('academic_programme');
            
            // Employee specific fields
            $table->string('employee_id')->nullable()->after('year_of_study');
            $table->string('department')->nullable()->after('employee_id');
            
            // Child specific fields
            $table->date('date_of_birth')->nullable()->after('department');
            $table->string('guardian_name')->nullable()->after('date_of_birth');
            $table->string('guardian_phone')->nullable()->after('guardian_name');
            $table->foreignId('guardian_id')->nullable()->constrained('parishioners')->onDelete('cascade')->after('guardian_phone');
            
            // Relationships
            $table->foreignId('community_id')->nullable()->constrained('communities')->onDelete('set null')->after('guardian_id');
            
            // Status
            $table->enum('status', ['active', 'alumni', 'inactive'])->default('active')->after('community_id');
            
            // Indexes
            $table->index(['member_type']);
            $table->index(['registration_number']);
            $table->index(['academic_programme']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parishioners', function (Blueprint $table) {
            $table->dropForeign(['guardian_id']);
            $table->dropForeign(['community_id']);
            $table->dropIndex(['member_type']);
            $table->dropIndex(['registration_number']);
            $table->dropIndex(['academic_programme']);
            $table->dropIndex(['status']);
            
            $table->dropColumn([
                'member_type',
                'registration_number',
                'academic_programme',
                'year_of_study',
                'employee_id',
                'department',
                'date_of_birth',
                'guardian_name',
                'guardian_phone',
                'guardian_id',
                'community_id',
                'status'
            ]);
        });
    }
};
