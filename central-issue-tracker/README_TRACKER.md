# Centralized Issue Tracker

A dedicated CodeIgniter 4 application to manage tasks, bug fixes, roadmaps, and user requests for all your intranet applications in one place.

## Features
- **Project Tracking:** Register all your intranet apps (7+).
- **Issue Classification:** Categorize as Bug, Task, Plan, or Request.
- **Priority & Status Management:** Track what's critical and what's completed.
- **VS Code Dark Theme:** High-contrast UI for developers.
- **MySQL Driven:** Uses a real database for easy export and migration.
- **CLI Database Manager:** Interactive command-line interface for database operations.

## Database Configuration

### Target Database: `tps2015gh_issue_tracker`

**Default Credentials:**
- Host: `localhost`
- User: `root`
- Password: (blank)
- Database: `tps2015gh_issue_tracker`

### Quick Database Setup Using CLI

The application includes a powerful interactive CLI tool for database management:

```bash
php spark db:manager
```

**Available Options:**
1. **Check Database Exist** - Verify if the database exists
2. **List All Databases** - Show all MySQL databases
3. **Create Database** - Create `tps2015gh_issue_tracker` automatically
4. **Initialize Database** - Run migrations to create all tables
5. **Export Database** - Backup to SQL file with timestamp
6. **Import Database** - Restore from SQL backup
7. **List Export Files** - View available backup files
8. **Test MySQL Connection** - Verify database connectivity
9. **Switch Database Configuration** - Change target database

### Manual Database Setup

If you prefer manual setup:

1. **Create Database:**
   ```bash
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS tps2015gh_issue_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
   ```

2. **Run Migrations:**
   ```bash
   php spark migrate --all
   ```

## Migration & Export

### Using CLI Tool (Recommended)

The built-in CLI manager makes migration easy:

**Export Database:**
```bash
php spark db:manager
# Select option [5] to export
```

**Import on New Machine:**
```bash
php spark db:manager
# Select option [6] to import
```

### Manual Export/Import

**Export Database:**
```bash
mysqldump -u root tps2015gh_issue_tracker > export.sql
```

**Setup on New Machine:**
1. Copy this folder
2. Create `tps2015gh_issue_tracker` database
3. Import `export.sql`
4. Update `.env` with new DB credentials
5. Run: `php spark db:manager` to verify setup

## Quick Start

### Prerequisites
- PHP 8.1 or higher
- MySQL/MariaDB server running
- Composer installed

### Installation Steps

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Configure Environment:**
   - The `.env` file is pre-configured for `tps2015gh_issue_tracker`
   - Modify if needed for your setup

3. **Setup Database:**
   ```bash
   # Interactive CLI setup (Recommended)
   php spark db:manager
   ```
   
   **Or manual setup:**
   ```bash
   # Create database manually
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS tps2015gh_issue_tracker;"
   
   # Run migrations
   php spark migrate --all
   ```

4. **Run Application:**
   ```bash
   php spark serve --port 8081
   ```

5. **Access at:** `http://localhost:8081`

## CLI Commands Reference

### Database Manager
```bash
# Launch interactive database menu
php spark db:manager
```

### Standard CodeIgniter Commands
```bash
# Run migrations
php spark migrate

# Check migration status
php spark migrate:status

# Run seeds
php spark db:seed <SeederName>

# List all available commands
php spark list
```

## Project Structure

```
central-issue-tracker/
├── app/
│   ├── Commands/
│   │   └── DatabaseManager.php      # CLI database manager
│   ├── Controllers/
│   │   ├── Dashboard.php
│   │   ├── Projects.php
│   │   ├── Issues.php
│   │   └── ...
│   ├── Database/
│   │   └── Migrations/
│   │       └── 2026-04-07-050000_CreateCentralIssueTables.php
│   ├── Helpers/
│   │   └── database_helper.php      # Database utility functions
│   └── Models/
├── writable/
│   └── exports/                      # Database export files
├── .env                              # Environment configuration
├── .env_mysql                        # MySQL template
└── spark                             # CLI entry point
```

## Developer Notes

### Database Helper Functions

The `app/Helpers/database_helper.php` provides reusable functions:

- `check_database_exists($dbname)` - Check if database exists
- `list_databases()` - List all MySQL databases
- `create_database($dbname)` - Create new database
- `export_database($dbname, $filepath)` - Export to SQL file
- `import_database($dbname, $filepath)` - Import from SQL file
- `run_migrations()` - Execute CodeIgniter migrations
- `test_mysql_connection()` - Test database connectivity
- `get_export_files($dir)` - List export files
- `format_file_size($bytes)` - Human-readable file sizes

### Configuration Files

- **`.env`** - Active environment configuration
- **`.env_mysql`** - MySQL configuration template
- **`app/Config/Database.php`** - Database connection configs including `tps2015gh` preset

### Main Controllers

- `Dashboard.php` - Main dashboard view
- `Projects.php` - Project CRUD operations
- `Issues.php` - Issue management
- `Auth.php` - Authentication
- `History.php` - Audit history

### UI

- Uses Bootstrap 5 with custom VS Code inspired CSS
- Dark/high-contrast theme for developers
- Responsive design for monitoring

## Troubleshooting

### Database Connection Issues

**Problem:** Cannot connect to MySQL
```bash
# Test connection
php spark db:manager
# Select option [8] Test MySQL Connection
```

**Solution:** 
- Ensure MySQL service is running
- Check `.env` database credentials
- Verify MySQL port (default: 3306)

### Migration Failures

**Problem:** Migrations fail
```bash
# Check migration status
php spark migrate:status

# Force rollback and re-migrate
php spark migrate:rollback
php spark migrate --all
```

### Missing Export Files

**Problem:** No exports directory
```bash
# Create manually
mkdir writable/exports
chmod 755 writable/exports
```

## License

See LICENSE file for details.
