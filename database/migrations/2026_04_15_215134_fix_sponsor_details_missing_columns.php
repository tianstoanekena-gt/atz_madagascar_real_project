<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            // Ajouter is_published si manquant
            if (!Schema::hasColumn('sponsor_details', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('long_description');
                $table->index('is_published', 'idx_sponsor_details_is_published');
            }

            // Ajouter les colonnes multilingues si manquantes
            if (!Schema::hasColumn('sponsor_details', 'long_description_mg')) {
                $table->text('long_description_mg')->nullable()->after('long_description');
            }
            if (!Schema::hasColumn('sponsor_details', 'long_description_fr')) {
                $table->text('long_description_fr')->nullable()->after('long_description_mg');
            }
            if (!Schema::hasColumn('sponsor_details', 'long_description_en')) {
                $table->text('long_description_en')->nullable()->after('long_description_fr');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            // Supprimer les colonnes si on rollback
            if (Schema::hasColumn('sponsor_details', 'is_published')) {
                $table->dropIndex('idx_sponsor_details_is_published');
                $table->dropColumn('is_published');
            }
            $table->dropColumn(['long_description_mg', 'long_description_fr', 'long_description_en']);
        });
    }
};
