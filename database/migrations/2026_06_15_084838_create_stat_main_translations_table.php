<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stat_main_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stat_main_id')->constrained('stat_main')->cascadeOnDelete();
            $table->enum('locale', ['mg', 'fr', 'en']);
            $table->string('label')->nullable();
            $table->string('trend', 100)->nullable();
            $table->string('detail', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['stat_main_id', 'locale']);
            $table->index(['locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stat_main_translations');
    }
};
