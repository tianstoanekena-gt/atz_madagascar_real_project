<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Traductions pour la description
            $table->text('description_mg')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_mg');

            // Traductions pour les besoins
            $table->text('needs_mg')->nullable()->after('needs');
            $table->text('needs_en')->nullable()->after('needs_mg');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['description_mg', 'description_en', 'needs_mg', 'needs_en']);
        });
    }
};
