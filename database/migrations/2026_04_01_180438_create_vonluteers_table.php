<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nom (non traduit)
            $table->string('photo');                   // Chemin photo
            $table->integer('order')->default(0);      // Ordre d'affichage
            $table->year('volunteer_since');           // Année de début (ex: 2022)
            $table->boolean('is_active')->default(true); // Actif/Inactif
            $table->timestamps();

            $table->index('order');
            $table->index('is_active');
            $table->index('volunteer_since');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
