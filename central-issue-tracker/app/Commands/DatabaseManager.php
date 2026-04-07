<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DatabaseManager extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Database';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'db:manager';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Interactive database management menu for MySQL database operations.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'db:manager';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Target database name
     */
    private string $targetDatabase = 'tps2015gh_issue_tracker';

    /**
     * Export directory path
     */
    private string $exportDir;

    /**
     * Executes the Command.
     */
    public function run(array $params)
    {
        // Load helper
        helper('database');
        
        // Initialize export directory
        $this->exportDir = WRITEPATH . 'exports';
        
        // Ensure export directory exists
        if (!is_dir($this->exportDir)) {
            mkdir($this->exportDir, 0755, true);
        }
        
        // Main menu loop
        while (true) {
            $this->showMenu();
            $choice = $this->getUserChoice();
            
            if ($choice === false) {
                continue;
            }
            
            if (!$this->processChoice($choice)) {
                break; // Exit the loop
            }
        }
        
        CLI::write(PHP_EOL . CLI::color('Database Manager exited. Goodbye!', 'green'), PHP_EOL);
    }

    /**
     * Display the main menu
     */
    private function showMenu()
    {
        CLI::newLine();
        CLI::write(CLI::color('╔══════════════════════════════════════════════════════════╗', 'cyan'));
        CLI::write(CLI::color('║       MySQL Database Manager - Central Issue Tracker      ║', 'cyan'));
        CLI::write(CLI::color('╚══════════════════════════════════════════════════════════╝', 'cyan'));
        CLI::newLine();
        CLI::write(CLI::color("Target Database: {$this->targetDatabase}", 'yellow'));
        CLI::write(CLI::color("Export Directory: {$this->exportDir}", 'yellow'));
        CLI::newLine();
        
        CLI::write(CLI::color('┌──────────────────────────────────────────────────────────┐', 'green'));
        CLI::write(CLI::color('│  MAIN MENU                                               │', 'green'));
        CLI::write(CLI::color('├──────────────────────────────────────────────────────────┤', 'green'));
        CLI::write(CLI::color('│  [1] Check Database Exist                                │', 'green'));
        CLI::write(CLI::color('│  [2] List All Databases                                  │', 'green'));
        CLI::write(CLI::color('│  [3] Create Database                                     │', 'green'));
        CLI::write(CLI::color('│  [4] Initialize Database (Run Migrations)                │', 'green'));
        CLI::write(CLI::color('│  [5] Export Database                                     │', 'green'));
        CLI::write(CLI::color('│  [6] Import Database                                     │', 'green'));
        CLI::write(CLI::color('│  [7] List Export Files                                   │', 'green'));
        CLI::write(CLI::color('│  [8] Test MySQL Connection                               │', 'green'));
        CLI::write(CLI::color('│  [9] Switch Database Configuration                       │', 'green'));
        CLI::write(CLI::color('│  [0] Exit                                                │', 'green'));
        CLI::write(CLI::color('└──────────────────────────────────────────────────────────┘', 'green'));
        CLI::newLine();
    }

    /**
     * Get user's menu choice
     */
    private function getUserChoice()
    {
        $choice = CLI::prompt('Enter your choice [0-9]', null, 'required');
        
        // Validate input
        if (!is_numeric($choice) || $choice < 0 || $choice > 9) {
            CLI::error('Invalid choice. Please enter a number between 0 and 9.');
            return false;
        }
        
        return (int)$choice;
    }

    /**
     * Process the user's choice
     */
    private function processChoice(int $choice): bool
    {
        CLI::newLine();
        
        switch ($choice) {
            case 0:
                return false; // Exit
                
            case 1:
                $this->checkDatabaseExist();
                break;
                
            case 2:
                $this->listDatabases();
                break;
                
            case 3:
                $this->createDatabase();
                break;
                
            case 4:
                $this->initializeDatabase();
                break;
                
            case 5:
                $this->exportDatabase();
                break;
                
            case 6:
                $this->importDatabase();
                break;
                
            case 7:
                $this->listExportFiles();
                break;
                
            case 8:
                $this->testConnection();
                break;
                
            case 9:
                $this->switchDatabaseConfig();
                break;
                
            default:
                CLI::error('Invalid choice.');
                break;
        }
        
        CLI::newLine();
        CLI::write(str_repeat('─', 60));
        
        return true; // Continue
    }

    /**
     * Check if database exists
     */
    private function checkDatabaseExist()
    {
        CLI::write(CLI::color('Checking database existence...', 'cyan'));
        
        $exists = check_database_exists($this->targetDatabase);
        
        if ($exists) {
            CLI::write(CLI::color("✓ Database '{$this->targetDatabase}' EXISTS", 'green'));
        } else {
            CLI::error("✗ Database '{$this->targetDatabase}' does NOT exist");
            CLI::write(CLI::color("  Use option [3] to create it.", 'yellow'));
        }
    }

    /**
     * List all databases
     */
    private function listDatabases()
    {
        CLI::write(CLI::color('Fetching database list...', 'cyan'));
        
        $databases = list_databases();
        
        if (empty($databases)) {
            CLI::write('No databases found.');
            return;
        }
        
        CLI::write(CLI::color("\nAvailable Databases:", 'green'));
        CLI::write(str_repeat('─', 40));
        
        foreach ($databases as $index => $db) {
            $marker = ($db === $this->targetDatabase) ? CLI::color(' [TARGET]', 'yellow') : '';
            CLI::write(sprintf('  %d. %s%s', $index + 1, $db, $marker));
        }
        
        CLI::write(str_repeat('─', 40));
        CLI::write(CLI::color("Total: " . count($databases) . " database(s)", 'cyan'));
    }

    /**
     * Create database
     */
    private function createDatabase()
    {
        CLI::write(CLI::color("Creating database '{$this->targetDatabase}'...", 'cyan'));
        
        if (check_database_exists($this->targetDatabase)) {
            CLI::error("Database '{$this->targetDatabase}' already exists!");
            CLI::write(CLI::color('  Use option [4] to initialize it with migrations.', 'yellow'));
            return;
        }
        
        $confirm = CLI::prompt("Create database '{$this->targetDatabase}'? [y/n]", 'n', 'required');
        
        if (strtolower($confirm) !== 'y') {
            CLI::write('Operation cancelled.');
            return;
        }
        
        $result = create_database($this->targetDatabase);
        
        if ($result) {
            CLI::write(CLI::color("✓ Database created successfully!", 'green'));
            CLI::write(CLI::color('  You can now use option [4] to run migrations.', 'yellow'));
        } else {
            CLI::error('Failed to create database. Check logs for details.');
        }
    }

    /**
     * Initialize database with migrations
     */
    private function initializeDatabase()
    {
        CLI::write(CLI::color('Initializing database with migrations...', 'cyan'));
        
        if (!check_database_exists($this->targetDatabase)) {
            CLI::error("Database '{$this->targetDatabase}' does not exist!");
            CLI::write(CLI::color('  Use option [3] to create it first.', 'yellow'));
            return;
        }
        
        $confirm = CLI::prompt("Run migrations on '{$this->targetDatabase}'? [y/n]", 'n', 'required');
        
        if (strtolower($confirm) !== 'y') {
            CLI::write('Operation cancelled.');
            return;
        }
        
        CLI::write(CLI::color('Running migrations...', 'cyan'));
        $result = run_migrations();
        
        if ($result['success']) {
            CLI::write(CLI::color('✓ ' . $result['message'], 'green'));
        } else {
            CLI::error($result['message']);
        }
    }

    /**
     * Export database
     */
    private function exportDatabase()
    {
        CLI::write(CLI::color('Exporting database...', 'cyan'));
        
        if (!check_database_exists($this->targetDatabase)) {
            CLI::error("Database '{$this->targetDatabase}' does not exist!");
            return;
        }
        
        // Generate filename with timestamp
        $timestamp = date('Y-m-d_His');
        $filename = "{$this->targetDatabase}_{$timestamp}.sql";
        $filepath = $this->exportDir . DIRECTORY_SEPARATOR . $filename;
        
        CLI::write("Export file: {$filename}");
        
        $confirm = CLI::prompt("Proceed with export? [y/n]", 'y', 'required');
        
        if (strtolower($confirm) !== 'y') {
            CLI::write('Operation cancelled.');
            return;
        }
        
        CLI::write(CLI::color('Exporting...', 'cyan'));
        $result = export_database($this->targetDatabase, $filepath);
        
        if ($result['success']) {
            CLI::write(CLI::color('✓ ' . $result['message'], 'green'));
        } else {
            CLI::error($result['message']);
        }
    }

    /**
     * Import database
     */
    private function importDatabase()
    {
        CLI::write(CLI::color('Importing database...', 'cyan'));
        
        // List available export files
        $files = get_export_files($this->exportDir);
        
        if (empty($files)) {
            CLI::write('No export files found in: ' . $this->exportDir);
            return;
        }
        
        CLI::write(CLI::color("\nAvailable Export Files:", 'green'));
        CLI::write(str_repeat('─', 60));
        
        foreach ($files as $index => $file) {
            $size = format_file_size($file['filesize']);
            CLI::write(sprintf('  [%d] %s (%s) - %s', $index + 1, $file['filename'], $size, $file['modified']));
        }
        
        CLI::write(str_repeat('─', 60));
        
        $fileChoice = CLI::prompt('Enter file number to import (0 to cancel)', null, 'required');
        
        if (!is_numeric($fileChoice) || $fileChoice < 0 || $fileChoice > count($files)) {
            CLI::error('Invalid file number.');
            return;
        }
        
        if ($fileChoice == 0) {
            CLI::write('Operation cancelled.');
            return;
        }
        
        $selectedFile = $files[$fileChoice - 1];
        
        CLI::newLine();
        CLI::error('WARNING: This will overwrite the current database!');
        $confirm = CLI::prompt("Import '{$selectedFile['filename']}' into '{$this->targetDatabase}'? [y/n]", 'n', 'required');
        
        if (strtolower($confirm) !== 'y') {
            CLI::write('Operation cancelled.');
            return;
        }
        
        CLI::write(CLI::color('Importing...', 'cyan'));
        $result = import_database($this->targetDatabase, $selectedFile['filepath']);
        
        if ($result['success']) {
            CLI::write(CLI::color('✓ ' . $result['message'], 'green'));
        } else {
            CLI::error($result['message']);
        }
    }

    /**
     * List export files
     */
    private function listExportFiles()
    {
        CLI::write(CLI::color('Listing export files...', 'cyan'));
        
        $files = get_export_files($this->exportDir);
        
        if (empty($files)) {
            CLI::write('No export files found in: ' . $this->exportDir);
            return;
        }
        
        CLI::write(CLI::color("\nExport Files:", 'green'));
        CLI::write(str_repeat('─', 70));
        
        foreach ($files as $index => $file) {
            $size = format_file_size($file['filesize']);
            CLI::write(sprintf('  %d. %s', $index + 1, $file['filename']));
            CLI::write(sprintf('     Size: %s | Modified: %s', $size, $file['modified']));
        }
        
        CLI::write(str_repeat('─', 70));
        CLI::write(CLI::color("Total: " . count($files) . " file(s)", 'cyan'));
    }

    /**
     * Test MySQL connection
     */
    private function testConnection()
    {
        CLI::write(CLI::color('Testing MySQL connection...', 'cyan'));
        
        $result = test_mysql_connection();
        
        if ($result['success']) {
            CLI::write(CLI::color('✓ ' . $result['message'], 'green'));
        } else {
            CLI::error($result['message']);
            CLI::write(CLI::color('  Please check your .env database configuration.', 'yellow'));
        }
    }

    /**
     * Switch database configuration
     */
    private function switchDatabaseConfig()
    {
        CLI::write(CLI::color('Switch Database Configuration', 'cyan'));
        CLI::write(str_repeat('─', 60));
        CLI::newLine();
        
        CLI::write('Current target: ' . CLI::color($this->targetDatabase, 'yellow'));
        CLI::newLine();
        
        $options = [
            'tps2015gh_issue_tracker' => 'TPS 2015 GH Issue Tracker',
            'central_issue_tracker' => 'Central Issue Tracker',
            'win_audit' => 'Win Audit',
            'custom' => 'Custom database name'
        ];
        
        CLI::write('Available presets:');
        foreach ($options as $key => $label) {
            $marker = ($key === $this->targetDatabase) ? CLI::color(' [CURRENT]', 'green') : '';
            CLI::write("  - {$label} ({$key}){$marker}");
        }
        
        CLI::newLine();
        $choice = CLI::prompt('Enter database name or preset key', null, 'required');
        
        if (empty($choice)) {
            CLI::write('Operation cancelled.');
            return;
        }
        
        // Check if it's a preset key
        if (isset($options[$choice])) {
            $this->targetDatabase = $choice;
        } else {
            $this->targetDatabase = $choice;
        }
        
        CLI::write(CLI::color("✓ Target database changed to: {$this->targetDatabase}", 'green'));
    }
}
