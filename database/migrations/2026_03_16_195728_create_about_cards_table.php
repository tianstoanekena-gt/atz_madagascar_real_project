<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_cards', function (Blueprint $table) {
            $table->id();
            $table->enum('lang', ['mg', 'fr', 'en']);
            $table->string('card_icon');
            $table->string('card_title');
            $table->text('card_description');
            $table->timestamps();

            $table->index('lang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_cards');
    }
};
