<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->onDelete('cascade');
            $table->enum('lang', ['mg', 'fr', 'en']);
            $table->string('role');              // Rôle (traduit)
            $table->text('description')->nullable(); // Description (traduite)
            $table->timestamps();

            $table->index(['volunteer_id', 'lang']);
            $table->unique(['volunteer_id', 'lang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_translations');
    }
};
