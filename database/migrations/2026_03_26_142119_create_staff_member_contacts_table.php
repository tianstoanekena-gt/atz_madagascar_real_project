<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_member_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('staff_members')->onDelete('cascade');
            $table->foreignId('contact_type_id')->constrained('contact_types')->onDelete('cascade');
            $table->string('contact_value');
            $table->string('custom_url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index(['member_id', 'contact_type_id']);
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_member_contacts');
    }
};
