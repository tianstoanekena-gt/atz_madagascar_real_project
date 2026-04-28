<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsor_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->text('long_description')->nullable();
            $table->timestamps();
            $table->unique('sponsor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_details');
    }
};
