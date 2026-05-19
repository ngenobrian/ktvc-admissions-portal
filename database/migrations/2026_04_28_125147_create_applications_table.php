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
        Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Application Tracking
        $table->string('admission_number')->unique()->nullable();
        $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
        $table->enum('admission_source', ['direct', 'kuccps'])->default('direct');
        
        // Student Particulars
        $table->string('first_name')->nullable();
        $table->string('middle_name')->nullable();
        $table->string('surname')->nullable();
        $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
        $table->date('dob')->nullable();
        $table->enum('marital_status', ['Single', 'Married'])->nullable();
        $table->string('phone_number')->nullable();
        
        $table->boolean('consent_given')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
