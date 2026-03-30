<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_member_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('staff_members')->onDelete('cascade');
            $table->enum('lang', ['mg', 'fr', 'en']);
            $table->string('role');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'lang']);
            $table->unique(['member_id', 'lang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_member_translations');
    }
};
