<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsor_detail_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_detail_id')->constrained('sponsor_details')->onDelete('cascade');
            $table->string('photo');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_detail_photos');
    }
};
