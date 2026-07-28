<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ExportDatabaseController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'principal'])) {
            abort(403, 'Only administrators can export the database.');
        }

        $driver = config('database.default');

        $sql = "-- SISTECH College Management System Database Export\n";
        $sql .= "-- Date: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Driver: {$driver}\n";
        $sql .= "--\n";
        $sql .= "-- Import instructions:\n";
        $sql .= "-- 1. Set up a new database on your hosting\n";
        $sql .= "-- 2. Run: php artisan migrate --force\n";
        $sql .= "-- 3. Import this SQL file\n";
        $sql .= "-- 4. Run: php artisan db:seed --force\n\n";

        $tables = $this->getTables();
        $skip = ['migrations', 'cache', 'jobs', 'failed_jobs', 'personal_access_tokens', 'sessions'];

        foreach ($tables as $table) {
            if (in_array($table, $skip)) {
                continue;
            }
            $sql .= $this->exportTable($table);
        }

        $filename = 'sistech-db-export-' . date('Y-m-d-His') . '.sql';
        $sql .= "-- Export complete\n";

        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Content-Length' => strlen($sql),
        ]);
    }

    protected function getTables(): array
    {
        $driver = config('database.default');

        if ($driver === 'pgsql') {
            $results = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
            return array_map(fn($r) => $r->tablename, $results);
        }

        $results = DB::select('SHOW TABLES');
        $key = array_key_exists(0, $results) ? array_keys((array) $results[0])[0] : null;
        return $key ? array_map(fn($r) => (array) $r[$key], $results) : [];
    }

    protected function exportTable(string $table): string
    {
        $rows = DB::table($table)->get();

        if ($rows->isEmpty()) {
            return "-- Table: {$table} (empty)\n\n";
        }

        $sql = "-- Table: {$table} ({$rows->count()} rows)\n";

        $columns = array_keys((array) $rows->first());
        $columnList = implode(', ', array_map(fn($c) => "\"{$c}\"", $columns));

        foreach ($rows as $row) {
            $values = array_map(function ($value) {
                if ($value === null) return 'NULL';
                if (is_bool($value)) return $value ? 'TRUE' : 'FALSE';
                if (is_int($value) || is_float($value)) return $value;
                $escaped = str_replace("'", "''", (string) $value);
                return "'{$escaped}'";
            }, (array) $row);

            $sql .= "INSERT INTO \"{$table}\" ({$columnList}) VALUES (" . implode(', ', $values) . ");\n";
        }

        $sql .= "\n";

        return $sql;
    }
}
