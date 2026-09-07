<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('godparents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255);
            $table->string('whatsapp', 20); // Obligatoire
            $table->text('address');
            $table->string('photo')->nullable(); // Optionnel
            $table->timestamps();

            // Index
            $table->index('user_id');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('godparents');
    }
};
