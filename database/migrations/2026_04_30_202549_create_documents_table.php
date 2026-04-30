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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Titres multilingues
            $table->string('title_fr')->nullable();
            $table->string('title_mg')->nullable();
            $table->string('title_en')->nullable();

            // Descriptions multilingues
            $table->text('description_fr')->nullable();
            $table->text('description_mg')->nullable();
            $table->text('description_en')->nullable();

            // Fichier
            $table->string('file_path');
            $table->enum('file_type', ['pdf', 'word', 'excel', 'powerpoint']);
            $table->unsignedInteger('file_size'); // en octets
            $table->string('file_original_name');

            // Statistiques
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('download_count')->default(0);

            // Statut
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('order')->default(0);

            $table->timestamps();
            $table->softDeletes(); // Pour restauration si suppression accidentelle
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
