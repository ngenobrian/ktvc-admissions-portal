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
        Schema::create('uploaded_documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('application_id')->constrained()->onDelete('cascade');
        $table->enum('document_type', ['passport_photo', 'national_id', 'birth_cert', 'kcpe', 'kcse']);
        $table->string('file_path');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_documents');
    }
};
