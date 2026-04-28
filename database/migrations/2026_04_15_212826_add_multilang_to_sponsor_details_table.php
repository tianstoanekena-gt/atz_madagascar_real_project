<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            $table->text('long_description_mg')->nullable()->after('long_description');
            $table->text('long_description_fr')->nullable()->after('long_description_mg');
            $table->text('long_description_en')->nullable()->after('long_description_fr');

            $table->dropColumn('long_description');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            $table->dropColumn(['long_description_mg', 'long_description_fr', 'long_description_en']);
        });
    }
};
