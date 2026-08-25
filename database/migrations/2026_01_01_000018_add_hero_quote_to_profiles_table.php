<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('hero_quote')->nullable()->after('hero_image');
            $table->text('hero_quote_idn')->nullable()->after('hero_quote');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['hero_quote', 'hero_quote_idn']);
        });
    }
};
