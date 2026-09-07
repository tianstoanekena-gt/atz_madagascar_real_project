<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F']);
            $table->string('photo'); // Obligatoire
            $table->string('location', 150);
            $table->string('whatsapp', 20)->nullable(); // Facultatif (si adulte)
            $table->enum('education_level', [
                'primaire',
                'college',
                'lycee',
                'superieur',
                'formation_pro'
            ]);
            $table->text('description');
            $table->text('needs');
            $table->decimal('target_amount', 12, 2)->default(0);
            $table->decimal('collected_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'active', 'completed'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['status', 'order']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
