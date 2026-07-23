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
        Schema::create('project_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('locale', 5); // 'fr', 'mg', 'en'
            $table->string('title');
            $table->text('short_description')->nullable(); // Résumé pour les cartes
            $table->longText('full_description')->nullable(); // Contenu complet pour la page détail
            $table->timestamps();

            $table->unique(['project_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_translations');
    }
};
