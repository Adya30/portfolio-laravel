<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add Indonesian-language content columns so each record can carry both
     * English (default) and Bahasa Indonesia versions of its text. English
     * stays in the existing columns; the *_idn columns are optional and fall
     * back to the English value when empty.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('role_title_idn')->nullable()->after('role_title');
            $table->text('tagline_idn')->nullable()->after('tagline');
            $table->text('about_1_idn')->nullable()->after('about_1');
            $table->text('about_2_idn')->nullable()->after('about_2');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->text('desk_idn')->nullable()->after('desk');
            $table->text('full_desk_idn')->nullable()->after('full_desk');
            $table->json('fitur_idn')->nullable()->after('fitur');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('role_idn')->nullable()->after('role');
            $table->text('desk_idn')->nullable()->after('desk');
            $table->text('practicum_desc_idn')->nullable()->after('practicum_desc');
            $table->json('responsibilities_idn')->nullable()->after('responsibilities');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->string('nama_idn')->nullable()->after('nama');
            $table->text('desk_idn')->nullable()->after('desk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['role_title_idn', 'tagline_idn', 'about_1_idn', 'about_2_idn']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['desk_idn', 'full_desk_idn', 'fitur_idn']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['role_idn', 'desk_idn', 'practicum_desc_idn', 'responsibilities_idn']);
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['nama_idn', 'desk_idn']);
        });
    }
};
