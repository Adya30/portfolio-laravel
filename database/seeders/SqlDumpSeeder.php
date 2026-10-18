<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SqlDumpSeeder extends Seeder
{
    /**
     * Target tables to import in foreign-key dependency order.
     */
    protected array $targetTables = [
        'users',
        'profiles',
        'categories',
        'tools',
        'projects',
        'experiences',
        'certificates',
        'courses',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = database_path('seeders/adyakomp_adyaportfolio.sql');

        if (! file_exists($sqlPath)) {
            $this->command?->error("File SQL dump tidak ditemukan di: {$sqlPath}");
            return;
        }

        $sql = file_get_contents($sqlPath);
        $driver = DB::getDriverName();

        $this->command?->info("Memulai impor data dari adyakomp_adyaportfolio.sql (Driver: {$driver})...");

        // Nonaktifkan foreign key checks sementara
        $this->disableForeignKeys($driver);

        try {
            foreach ($this->targetTables as $table) {
                if (! Schema::hasTable($table)) {
                    $this->command?->warn("Tabel `{$table}` tidak ditemukan dalam schema, dilewati.");
                    continue;
                }

                $statements = $this->getTableInsertStatements($sql, $table);
                if (empty($statements)) {
                    $this->command?->line("Tabel `{$table}`: tidak ada statement INSERT.");
                    continue;
                }

                $records = [];
                foreach ($statements as $stmt) {
                    $parsed = $this->parseInsertStatement($stmt);
                    foreach ($parsed['rows'] as $row) {
                        if (count($row) === count($parsed['columns'])) {
                            $records[] = array_combine($parsed['columns'], $row);
                        }
                    }
                }

                // Kosongkan data tabel sebelum memasukkan data baru
                DB::table($table)->delete();

                // Masukkan data per chunk untuk efisiensi
                foreach (array_chunk($records, 50) as $chunk) {
                    DB::table($table)->insert($chunk);
                }

                $count = count($records);
                $this->command?->info("✓ Tabel `{$table}` berhasil diisi: {$count} data.");
            }
        } finally {
            // Aktifkan kembali foreign key checks
            $this->enableForeignKeys($driver);
        }

        $this->command?->info("Semua data dari adyakomp_adyaportfolio.sql berhasil di-seed!");
    }

    /**
     * Nonaktifkan foreign key constraints sesuai driver DB.
     */
    protected function disableForeignKeys(string $driver): void
    {
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
    }

    /**
     * Aktifkan kembali foreign key constraints sesuai driver DB.
     */
    protected function enableForeignKeys(string $driver): void
    {
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * Ekstrak statement INSERT untuk tabel tertentu dengan aman terhadap tanda kutip dan escape.
     */
    protected function getTableInsertStatements(string $sql, string $table): array
    {
        $stmts = [];
        $offset = 0;
        $prefix = "INSERT INTO `{$table}`";
        $len = strlen($sql);

        while (($pos = strpos($sql, $prefix, $offset)) !== false) {
            $inString = false;
            $stringChar = '';
            $escaped = false;
            $endPos = false;

            for ($i = $pos; $i < $len; $i++) {
                $ch = $sql[$i];
                if ($inString) {
                    if ($escaped) {
                        $escaped = false;
                    } elseif ($ch === '\\') {
                        $escaped = true;
                    } elseif ($ch === $stringChar) {
                        $inString = false;
                    }
                    continue;
                }
                if ($ch === "'" || $ch === '"') {
                    $inString = true;
                    $stringChar = $ch;
                    continue;
                }
                if ($ch === ';') {
                    $endPos = $i;
                    break;
                }
            }

            if ($endPos !== false) {
                $stmts[] = substr($sql, $pos, $endPos - $pos);
                $offset = $endPos + 1;
            } else {
                break;
            }
        }

        return $stmts;
    }

    /**
     * Parse baris nilai dari suatu statement INSERT SQL.
     */
    protected function parseInsertStatement(string $stmt): array
    {
        if (! preg_match('/^INSERT INTO `([^`]+)`\s*\((.*?)\)\s*VALUES\s*(.*)$/s', $stmt, $m)) {
            return ['table' => null, 'columns' => [], 'rows' => []];
        }

        $table = $m[1];
        $cols = array_map(fn($c) => trim(str_replace(['`', ' '], '', $c)), explode(',', $m[2]));

        $valStr = trim($m[3]);
        $len = strlen($valStr);

        $rows = [];
        $currentRow = [];
        $currentVal = '';
        $inString = false;
        $stringChar = '';
        $escaped = false;
        $inRow = false;
        $wasQuoted = false;

        for ($i = 0; $i < $len; $i++) {
            $ch = $valStr[$i];

            if ($inString) {
                if ($escaped) {
                    switch ($ch) {
                        case '0': $currentVal .= "\0"; break;
                        case 'b': $currentVal .= "\b"; break;
                        case 'n': $currentVal .= "\n"; break;
                        case 'r': $currentVal .= "\r"; break;
                        case 't': $currentVal .= "\t"; break;
                        case 'Z': $currentVal .= "\x1a"; break;
                        case '\\': $currentVal .= "\\"; break;
                        case '\'': $currentVal .= "'"; break;
                        case '"': $currentVal .= '"'; break;
                        default: $currentVal .= $ch; break;
                    }
                    $escaped = false;
                } elseif ($ch === '\\') {
                    $escaped = true;
                } elseif ($ch === $stringChar) {
                    if ($i + 1 < $len && $valStr[$i + 1] === $stringChar) {
                        $currentVal .= $stringChar;
                        $i++;
                    } else {
                        $inString = false;
                        $wasQuoted = true;
                    }
                } else {
                    $currentVal .= $ch;
                }
                continue;
            }

            if ($ch === "'" || $ch === '"') {
                $inString = true;
                $stringChar = $ch;
                $currentVal = '';
                $wasQuoted = true;
                continue;
            }

            if ($ch === '(' && ! $inRow) {
                $inRow = true;
                $currentRow = [];
                $currentVal = '';
                $wasQuoted = false;
                continue;
            }

            if ($ch === ')' && $inRow) {
                $currentRow[] = $this->formatVal($currentVal, $wasQuoted);
                $rows[] = $currentRow;
                $currentRow = [];
                $currentVal = '';
                $inRow = false;
                $wasQuoted = false;
                continue;
            }

            if ($ch === ',' && $inRow) {
                $currentRow[] = $this->formatVal($currentVal, $wasQuoted);
                $currentVal = '';
                $wasQuoted = false;
                continue;
            }

            if ($inRow && ! $wasQuoted) {
                $currentVal .= $ch;
            }
        }

        return [
            'table' => $table,
            'columns' => $cols,
            'rows' => $rows,
        ];
    }

    /**
     * Konversi token nilai SQL ke format PHP yang tepat (NULL, numeric, string).
     */
    protected function formatVal(string $val, bool $wasQuoted): mixed
    {
        if (! $wasQuoted) {
            $trimmed = trim($val);
            if (strcasecmp($trimmed, 'NULL') === 0) {
                return null;
            }
            if (is_numeric($trimmed)) {
                return $trimmed + 0;
            }
            return $trimmed;
        }

        return $val;
    }
}
