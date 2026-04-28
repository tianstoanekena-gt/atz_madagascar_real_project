<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsor_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->enum('lang', ['mg', 'fr', 'en']);
            $table->text('short_description');   // Description courte (carte)
            $table->timestamps();

            $table->index(['sponsor_id', 'lang']);
            $table->unique(['sponsor_id', 'lang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_translations');
    }
};
