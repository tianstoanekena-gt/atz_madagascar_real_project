<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->onDelete('cascade');
            $table->foreignId('contact_type_id')->constrained('contact_types')->onDelete('cascade');
            $table->string('contact_value');
            $table->string('custom_url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index(['volunteer_id', 'contact_type_id']);
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_contacts');
    }
};
