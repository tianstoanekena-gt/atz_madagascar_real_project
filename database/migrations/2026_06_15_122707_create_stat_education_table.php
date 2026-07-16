<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stat_education', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->decimal('value', 10, 2);
            $table->string('unit', 20)->nullable();
            $table->enum('display_type', ['progress', 'percentage', 'chart_bar'])->default('progress');
            $table->string('chart_label', 50)->nullable(); // ex: "Primaire"
            $table->decimal('percentage_value', 5, 2)->nullable(); // ex: 54.00
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['year', 'is_published', 'order']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('stat_education');
    }
};
