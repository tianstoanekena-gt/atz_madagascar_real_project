<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_intervention_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained('about_interventions')->onDelete('cascade');
            $table->enum('lang', ['mg', 'fr', 'en']);
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->index(['intervention_id', 'lang']);
            $table->unique(['intervention_id', 'lang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_intervention_translations');
    }
};
