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

        if ($driver === 'pgsql') {
            return $this->exportPostgres();
        } elseif ($driver === 'mysql') {
            return $this->exportMysql();
        }

        abort(500, "Unsupported database driver: {$driver}");
    }

    protected function exportPostgres()
    {
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port');
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');

        $escapedPassword = escapeshellarg($password);
        $command = sprintf(
            'PGPASSWORD=%s pg_dump -h %s -p %s -U %s -d %s --no-owner --no-acl --format=plain 2>&1',
            $password,
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($database)
        );

        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            abort(500, "pg_dump failed: " . implode("\n", $output));
        }

        $sql = implode("\n", $output);
        $filename = 'sistech-db-export-' . date('Y-m-d-His') . '.sql';

        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Content-Length' => strlen($sql),
        ]);
    }

    protected function exportMysql()
    {
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $command = sprintf(
            'mysqldump -h %s -P %s -u %s %s --no-tablespaces 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($database)
        );

        if (!empty($password)) {
            $command = sprintf(
                'mysqldump -h %s -P %s -u %s -p%s %s --no-tablespaces 2>&1',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                $password,
                escapeshellarg($database)
            );
        }

        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            abort(500, "mysqldump failed: " . implode("\n", $output));
        }

        $sql = implode("\n", $output);
        $filename = 'sistech-db-export-' . date('Y-m-d-His') . '.sql';

        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Content-Length' => strlen($sql),
        ]);
    }
}
