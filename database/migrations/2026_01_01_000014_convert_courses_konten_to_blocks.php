<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replace the flat konten/konten_idn text columns with a single JSON
     * column holding structured content blocks (subbab, paragraf, gambar,
     * kode) rendered by the course detail page.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['konten', 'konten_idn']);
            $table->json('konten')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('konten');
            $table->longText('konten')->nullable();
            $table->longText('konten_idn')->nullable();
        });
    }
};
