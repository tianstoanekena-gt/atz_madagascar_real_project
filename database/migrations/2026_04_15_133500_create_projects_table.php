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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('project_categories')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('ongoing');
            $table->string('hero_image')->nullable();
            $table->string('location')->nullable(); // Lieu spécifique (ex: "FJKM Andranovelona")
            $table->string('city')->nullable(); // Ville (ex: "Antananarivo")
            $table->decimal('target_amount', 12, 2)->nullable(); // Objectif financier
            $table->decimal('current_amount', 12, 2)->default(0); // Montant déjà réuni
            $table->integer('beneficiaries_count')->nullable(); // Nombre de bénéficiaires
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
