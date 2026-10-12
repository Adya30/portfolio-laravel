<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('konten')->nullable()->after('gambar');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->json('konten')->nullable()->after('gambar');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('konten');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn('konten');
        });
    }
};
