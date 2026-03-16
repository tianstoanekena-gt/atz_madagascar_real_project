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
        Schema::table('about_videos', function (Blueprint $table) {
            $table->dropColumn('file_path');
            $table->string('video_url')->after('lang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_videos', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->string('file_path')->after('lang');
        });
    }
};
