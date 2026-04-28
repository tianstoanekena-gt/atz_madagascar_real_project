<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('long_description');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};
