<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Add the live demo link column and split legacy project links:
     * GitHub repository URLs stay in `link`, everything else (live sites,
     * demo documents, etc.) moves to `link_live`.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('link_live')->nullable()->after('link');
        });

        foreach (DB::table('projects')->whereNotNull('link')->get() as $project) {
            if (! $project->link) {
                continue;
            }

            $isGithub = Str::startsWith($project->link, ['https://github.com/', 'http://github.com/', 'github.com/']);

            if (! $isGithub) {
                DB::table('projects')->where('id', $project->id)->update([
                    'link' => null,
                    'link_live' => $project->link,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('link_live');
        });
    }
};
