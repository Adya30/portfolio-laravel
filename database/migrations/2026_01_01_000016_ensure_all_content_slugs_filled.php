<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->generateMissingSlugs('courses', 'nama');
        $this->generateMissingSlugs('projects', 'nama');
        $this->generateMissingSlugs('certificates', 'nama');
        $this->generateMissingSlugs('experiences', 'role');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: filled missing slugs do not need to be reverted.
    }

    private function generateMissingSlugs(string $table, string $nameColumn): void
    {
        $rows = DB::table($table)
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->select('id', $nameColumn)
            ->get();

        foreach ($rows as $row) {
            $name = $row->$nameColumn ?? $table;
            $slug = Str::slug($name) ?: $table;

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
