<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stat_nutrition', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->decimal('value', 10, 2);
            $table->string('unit', 20)->nullable();
            $table->enum('display_type', ['counter'])->default('counter');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['year', 'is_published', 'order']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('stat_nutrition');
    }
};
