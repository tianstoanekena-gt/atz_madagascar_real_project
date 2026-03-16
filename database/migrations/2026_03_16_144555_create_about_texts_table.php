<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_texts', function (Blueprint $table) {
            $table->id();
            $table->enum('lang', ['mg', 'fr', 'en']);
            $table->text('content');
            $table->timestamps();

            $table->index('lang');
            $table->unique(['lang']); // Une seule version par langue
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_texts');
    }
};
