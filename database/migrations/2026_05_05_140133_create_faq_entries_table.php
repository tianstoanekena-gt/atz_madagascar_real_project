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
        Schema::create('faq_entries', function (Blueprint $table) {
            $table->id();

            // Catégorie
            $table->enum('category', ['general', 'membership', 'donation', 'activities', 'contact']);

            // Ordre d'affichage
            $table->unsignedInteger('order')->default(0);

            // Questions multilingues
            $table->string('question_mg')->nullable();
            $table->string('question_fr')->nullable();
            $table->string('question_en')->nullable();

            // Réponses multilingues (HTML autorisé)
            $table->text('answer_mg')->nullable();
            $table->text('answer_fr')->nullable();
            $table->text('answer_en')->nullable();

            // Statut & Métriques
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('view_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Index pour performances
            $table->index(['category', 'is_published', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_entries');
    }
};
