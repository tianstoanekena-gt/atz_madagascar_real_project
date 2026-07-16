<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stat_health_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stat_health_id')->constrained('stat_health')->cascadeOnDelete();
            $table->enum('locale', ['mg', 'fr', 'en']);
            $table->string('label')->nullable();
            $table->string('trend', 100)->nullable();
            $table->string('detail', 255)->nullable(); // ex: "dont 3 interventions chirurgicales"
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['stat_health_id', 'locale']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('stat_health_translations');
    }
};
