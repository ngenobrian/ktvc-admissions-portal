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
        Schema::table('applications', function (Blueprint $table) {
        $table->string('kcse_grade')->nullable()->after('phone_number');
        $table->integer('course_level')->nullable()->after('kcse_grade');
        $table->string('course_name')->nullable()->after('course_level');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
        $table->dropColumn(['kcse_grade', 'course_level', 'course_name']);
    });
    }
};
