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
        Schema::table('users', function (Blueprint $table) {
        $table->string('phone_number')->nullable()->after('email');
        $table->string('job_title')->nullable()->after('phone_number'); // e.g., "HOD", "Clerk"
        $table->string('department')->nullable()->after('job_title');
        $table->boolean('must_change_password')->default(false)->after('password');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
