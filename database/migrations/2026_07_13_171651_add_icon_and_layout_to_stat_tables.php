<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['stat_main', 'stat_education', 'stat_nutrition', 'stat_health'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('icon', 50)->nullable()->after('display_type');
                $table->string('layout_style', 30)->default('card')->nullable()->after('icon');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['stat_main', 'stat_education', 'stat_nutrition', 'stat_health'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['icon', 'layout_style']);
            });
        }
    }
};
