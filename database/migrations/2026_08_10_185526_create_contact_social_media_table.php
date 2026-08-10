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
        Schema::create('contact_social_media', function (Blueprint $table) {
            $table->id();
            $table->string('name');   // Nom du profil affiché (ex: "Akany Tia Zaza Madagascar")
            $table->string('url');    // Lien universel (https://facebook.com/..., https://wa.me/..., mailto:...)
            $table->string('icon');   // Chemin de l'image icône uploadée
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_social_media');
    }
};
