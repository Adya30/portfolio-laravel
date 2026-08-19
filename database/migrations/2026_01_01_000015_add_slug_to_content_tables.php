<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['courses', 'projects', 'certificates', 'experiences'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('slug')->nullable()->after('id');
            });
        }

        // Auto-generate slugs from existing data
        $this->generateSlugs('courses', 'nama');
        $this->generateSlugs('projects', 'nama');
        $this->generateSlugs('certificates', 'nama');
        $this->generateSlugs('experiences', 'role');

        // Make slug required after data migration
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('slug')->unique()->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['courses', 'projects', 'certificates', 'experiences'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }

    private function generateSlugs(string $table, string $nameColumn): void
    {
        $rows = DB::table($table)->select('id', $nameColumn)->get();

        foreach ($rows as $row) {
            $slug = Str::slug($row->$nameColumn);

            // Ensure uniqueness
            $baseSlug = $slug;
            $counter = 1;
            while (DB::table($table)->where('slug', $slug)->where('id', '!=', $row->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table($table)->where('id', $row->id)->update(['slug' => $slug]);
        }
    }
};
