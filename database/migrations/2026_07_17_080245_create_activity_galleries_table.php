<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->string('image_path'); // Le chemin du fichier (ex: activities/gallery/xyz.jpg)
            $table->integer('order')->default(0); // Pour trier les images si besoin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_galleries');
    }
};
