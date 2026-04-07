<?php

/**
 * Database Management Helper Functions
 * 
 * Provides utility functions for MySQL database operations
 * including create, list, export, import, and migration management.
 */

use Config\Database;

if (!function_exists('get_mysql_connection')) {
    /**
     * Get a raw MySQL connection (not the CI4 database connection)
     * Used for administrative tasks like creating databases
     * 
     * @return mysqli
     */
    function get_mysql_connection(): mysqli
    {
        $config = config('Database');
        $default = $config->default;
        
        $conn = new mysqli(
            $default['hostname'],
            $default['username'],
            $default['password'],
            '', // No database selected yet
            $default['port'] ?? 3306
        );
        
        if ($conn->connect_error) {
            throw new Exception('MySQL Connection Failed: ' . $conn->connect_error);
        }
        
        return $conn;
    }
}

if (!function_exists('check_database_exists')) {
    /**
     * Check if a database exists
     * 
     * @param string $dbname Database name
     * @return bool
     */
    function check_database_exists(string $dbname): bool
    {
        try {
            $conn = get_mysql_connection();
            $result = $conn->query("SHOW DATABASES LIKE '{$dbname}'");
            $exists = $result->num_rows > 0;
            $conn->close();
            return $exists;
        } catch (Exception $e) {
            log_message('error', 'Error checking database existence: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('list_databases')) {
    /**
     * List all MySQL databases
     * 
     * @return array Array of database names
     */
    function list_databases(): array
    {
        try {
            $conn = get_mysql_connection();
            $result = $conn->query('SHOW DATABASES');
            $databases = [];
            
            while ($row = $result->fetch_assoc()) {
                $db = $row['Database'];
                // Filter out system databases
                if (!in_array($db, ['information_schema', 'mysql', 'performance_schema', 'sys'])) {
                    $databases[] = $db;
                }
            }
            
            $conn->close();
            return $databases;
        } catch (Exception $e) {
            log_message('error', 'Error listing databases: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('create_database')) {
    /**
     * Create a new database if it doesn't exist
     * 
     * @param string $dbname Database name
     * @param string $charset Character set (default: utf8mb4)
     * @param string $collation Collation (default: utf8mb4_general_ci)
     * @return bool Success status
     */
    function create_database(string $dbname, string $charset = 'utf8mb4', string $collation = 'utf8mb4_general_ci'): bool
    {
        try {
            if (check_database_exists($dbname)) {
                log_message('info', "Database '{$dbname}' already exists.");
                return false;
            }
            
            $conn = get_mysql_connection();
            $sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET {$charset} COLLATE {$collation}";
            
            if ($conn->query($sql) === TRUE) {
                log_message('info', "Database '{$dbname}' created successfully.");
                $conn->close();
                return true;
            } else {
                throw new Exception('Error creating database: ' . $conn->error);
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('export_database')) {
    /**
     * Export database to SQL file using mysqldump
     * 
     * @param string $dbname Database name
     * @param string $filepath Output file path
     * @return array Result array with 'success' and 'message' keys
     */
    function export_database(string $dbname, string $filepath): array
    {
        try {
            if (!check_database_exists($dbname)) {
                return [
                    'success' => false,
                    'message' => "Database '{$dbname}' does not exist."
                ];
            }
            
            // Ensure directory exists
            $dir = dirname($filepath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            $config = config('Database');
            $default = $config->default;
            
            // Build mysqldump command
            $password = $default['password'] ?? '';
            $passwordArg = $password !== '' ? "-p{$password}" : "";
            $command = sprintf(
                'mysqldump -h %s -u %s %s --databases %s --single-transaction --quick --lock-tables=false --routines --triggers --events > "%s"',
                $default['hostname'],
                $default['username'],
                $passwordArg,
                $dbname,
                $filepath
            );
            
            // Execute command
            $output = [];
            $returnVar = 0;
            exec($command . ' 2>&1', $output, $returnVar);
            
            if ($returnVar === 0 && file_exists($filepath)) {
                $filesize = filesize($filepath);
                $sizeFormatted = format_file_size($filesize);
                
                return [
                    'success' => true,
                    'message' => "Database exported successfully to: {$filepath} ({$sizeFormatted})",
                    'filepath' => $filepath,
                    'filesize' => $filesize
                ];
            } else {
                $errorMsg = implode("\n", $output);
                return [
                    'success' => false,
                    'message' => "Export failed: {$errorMsg}"
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Export error: ' . $e->getMessage()
            ];
        }
    }
}

if (!function_exists('import_database')) {
    /**
     * Import database from SQL file
     * 
     * @param string $dbname Database name
     * @param string $filepath Input SQL file path
     * @return array Result array with 'success' and 'message' keys
     */
    function import_database(string $dbname, string $filepath): array
    {
        try {
            if (!file_exists($filepath)) {
                return [
                    'success' => false,
                    'message' => "Import file not found: {$filepath}"
                ];
            }
            
            // Create database if it doesn't exist
            create_database($dbname);
            
            $config = config('Database');
            $default = $config->default;
            
            // Build mysql import command
            $password = $default['password'] ?? '';
            $passwordArg = $password !== '' ? "-p{$password}" : "";
            $command = sprintf(
                'mysql -h %s -u %s %s %s < "%s"',
                $default['hostname'],
                $default['username'],
                $passwordArg,
                $dbname,
                $filepath
            );
            
            // Execute command
            $output = [];
            $returnVar = 0;
            exec($command . ' 2>&1', $output, $returnVar);
            
            if ($returnVar === 0) {
                return [
                    'success' => true,
                    'message' => "Database imported successfully from: {$filepath}"
                ];
            } else {
                $errorMsg = implode("\n", $output);
                return [
                    'success' => false,
                    'message' => "Import failed: {$errorMsg}"
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Import error: ' . $e->getMessage()
            ];
        }
    }
}

if (!function_exists('run_migrations')) {
    /**
     * Run CodeIgniter migrations
     * 
     * @return array Result array with 'success' and 'message' keys
     */
    function run_migrations(): array
    {
        try {
            // Use the spark migrate command
            $command = 'php spark migrate --all';
            $output = [];
            $returnVar = 0;
            
            exec($command . ' 2>&1', $output, $returnVar);
            
            if ($returnVar === 0) {
                return [
                    'success' => true,
                    'message' => "Migrations completed successfully.",
                    'output' => $output
                ];
            } else {
                $errorMsg = implode("\n", $output);
                return [
                    'success' => false,
                    'message' => "Migration failed: {$errorMsg}"
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Migration error: ' . $e->getMessage()
            ];
        }
    }
}

if (!function_exists('test_mysql_connection')) {
    /**
     * Test MySQL connection
     * 
     * @return array Result array with 'success' and 'message' keys
     */
    function test_mysql_connection(): array
    {
        try {
            $conn = get_mysql_connection();
            $serverInfo = $conn->server_info;
            $conn->close();
            
            return [
                'success' => true,
                'message' => "MySQL connection successful (Server: {$serverInfo})"
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'MySQL connection failed: ' . $e->getMessage()
            ];
        }
    }
}

if (!function_exists('format_file_size')) {
    /**
     * Format file size in human-readable format
     * 
     * @param int $bytes File size in bytes
     * @return string Formatted size
     */
    function format_file_size(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

if (!function_exists('get_export_files')) {
    /**
     * Get list of export files in the exports directory
     * 
     * @param string $exportDir Export directory path
     * @return array Array of file information
     */
    function get_export_files(string $exportDir): array
    {
        if (!is_dir($exportDir)) {
            return [];
        }
        
        $files = glob($exportDir . '/*.sql');
        $fileList = [];
        
        foreach ($files as $file) {
            $fileList[] = [
                'filename' => basename($file),
                'filepath' => $file,
                'filesize' => filesize($file),
                'modified' => date('Y-m-d H:i:s', filemtime($file))
            ];
        }
        
        // Sort by modification time (newest first)
        usort($fileList, function ($a, $b) {
            return filemtime($b['filepath']) - filemtime($a['filepath']);
        });
        
        return $fileList;
    }
}
