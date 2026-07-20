<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * Directory path inside storage/app.
     */
    protected string $backupDir = 'backups';

    /**
     * Display a listing of database backup files.
     */
    public function index()
    {
        // Ensure backups directory exists
        if (!Storage::disk('local')->exists($this->backupDir)) {
            Storage::disk('local')->makeDirectory($this->backupDir);
        }

        $files = Storage::disk('local')->files($this->backupDir);
        $backups = [];
        $totalSize = 0;
        $latestBackup = null;

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $filename = basename($file);
                $size = Storage::disk('local')->size($file);
                $lastModified = Storage::disk('local')->lastModified($file);

                $totalSize += $size;
                if ($latestBackup === null || $lastModified > $latestBackup) {
                    $latestBackup = $lastModified;
                }

                $backups[] = [
                    'name' => $filename,
                    'path' => $file,
                    'size' => $this->formatBytes($size),
                    'size_raw' => $size,
                    'created_at' => \Carbon\Carbon::createFromTimestamp($lastModified),
                ];
            }
        }

        // Sort by creation date descending
        usort($backups, function ($a, $b) {
            return $b['created_at']->timestamp <=> $a['created_at']->timestamp;
        });

        $stats = [
            'total_count' => count($backups),
            'total_size' => $this->formatBytes($totalSize),
            'latest_backup' => $latestBackup ? \Carbon\Carbon::createFromTimestamp($latestBackup)->diffForHumans() : 'Never',
        ];

        return view('admin.backups.index', compact('backups', 'stats'));
    }

    /**
     * Generate a new database backup SQL dump file.
     */
    public function store(Request $request)
    {
        try {
            if (!Storage::disk('local')->exists($this->backupDir)) {
                Storage::disk('local')->makeDirectory($this->backupDir);
            }

            $dbName = config('database.connections.' . config('database.default') . '.database');
            $filename = 'backup-' . ($dbName ? str_replace(' ', '_', $dbName) : 'db') . '-' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = $this->backupDir . '/' . $filename;

            // Generate SQL Dump content using PDO
            $sqlContent = $this->generateSqlDump($dbName);

            Storage::disk('local')->put($filePath, $sqlContent);

            return redirect()->route('admin.backups.index')
                ->with('success', "Database backup '{$filename}' created successfully!");
        } catch (\Throwable $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Failed to create database backup: ' . $e->getMessage());
        }
    }

    /**
     * Download a specific backup file.
     */
    public function download(string $filename)
    {
        $safeFilename = basename($filename);
        $filePath = $this->backupDir . '/' . $safeFilename;

        if (!Storage::disk('local')->exists($filePath)) {
            return redirect()->route('admin.backups.index')->with('error', 'Backup file not found.');
        }

        return Storage::disk('local')->download($filePath);
    }

    /**
     * Delete a specific backup file.
     */
    public function destroy(string $filename)
    {
        $safeFilename = basename($filename);
        $filePath = $this->backupDir . '/' . $safeFilename;

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            return redirect()->route('admin.backups.index')
                ->with('success', "Backup file '{$safeFilename}' deleted successfully.");
        }

        return redirect()->route('admin.backups.index')->with('error', 'Backup file not found.');
    }

    /**
     * Generate pure PHP SQL dump content using PDO.
     */
    protected function generateSqlDump(?string $dbName): string
    {
        $pdo = DB::getPdo();
        $tables = [];

        // Fetch all tables
        $tablesResult = DB::select('SHOW FULL TABLES');
        foreach ($tablesResult as $row) {
            $rowArray = (array) $row;
            $values = array_values($rowArray);
            if (isset($values[1]) && $values[1] === 'BASE TABLE') {
                $tables[] = $values[0];
            } elseif (count($values) >= 1 && !isset($values[1])) {
                $tables[] = $values[0];
            }
        }

        $out = "-- ========================================================\n";
        $out .= "-- Database Backup: " . ($dbName ?? 'Laravel DB') . "\n";
        $out .= "-- Date Generated: " . date('Y-m-d H:i:s') . "\n";
        $out .= "-- Generated by INSPINIA Apps Management\n";
        $out .= "-- ========================================================\n\n";

        $out .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $out .= "-- --------------------------------------------------------\n";
            $out .= "-- Table structure for table `{$table}`\n";
            $out .= "-- --------------------------------------------------------\n";
            $out .= "DROP TABLE IF EXISTS `{$table}`;\n";

            $createResult = DB::select("SHOW CREATE TABLE `{$table}`");
            if (!empty($createResult)) {
                $createArray = (array) $createResult[0];
                $createSql = $createArray['Create Table'] ?? array_values($createArray)[1] ?? '';
                $out .= $createSql . ";\n\n";
            }

            // Dump data
            $rows = DB::table($table)->get();
            if ($rows->count() > 0) {
                $out .= "-- Dumping data for table `{$table}`\n";
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $cols = array_map(fn($c) => "`{$c}`", array_keys($rowArray));
                    $vals = array_map(function ($val) use ($pdo) {
                        if ($val === null) {
                            return 'NULL';
                        }
                        return $pdo->quote($val);
                    }, array_values($rowArray));

                    $out .= "INSERT INTO `{$table}` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
                }
                $out .= "\n";
            }
        }

        $out .= "SET FOREIGN_KEY_CHECKS=1;\n";
        return $out;
    }

    /**
     * Format bytes to human-readable format.
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
