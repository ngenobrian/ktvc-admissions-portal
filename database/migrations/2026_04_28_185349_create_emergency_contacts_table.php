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
        Schema::create('emergency_contacts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('application_id')->constrained()->onDelete('cascade');
        $table->enum('contact_type', ['father', 'mother', 'guardian', 'fee_sponsor']);
        $table->boolean('is_alive')->default(true); // For parents
        $table->string('full_name')->nullable();
        $table->string('phone_number')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
