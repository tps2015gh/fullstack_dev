# Database Manager CLI - Testing & Usage Guide

## Overview
This guide provides comprehensive testing instructions for the MySQL Database Manager CLI tool added to the Central Issue Tracker application.

## Prerequisites

### Required Software
1. **PHP 8.1+** - Command-line PHP must be installed and in system PATH
2. **MySQL/MariaDB** - Database server must be running
3. **Composer** - For managing dependencies

### Verify Prerequisites

```bash
# Check PHP version
php -v

# Check MySQL availability
mysql --version

# Verify Composer
composer --version
```

## Installation Verification

### Step 1: Verify Files Exist

Check that all required files are in place:

```bash
# Windows
dir app\Commands\DatabaseManager.php
dir app\Helpers\database_helper.php
dir writable\exports

# Linux/Mac
ls -la app/Commands/DatabaseManager.php
ls -la app/Helpers/database_helper.php
ls -la writable/exports
```

**Expected Output:** All files should exist.

### Step 2: Verify Composer Dependencies

```bash
cd D:\dev\fullstack_dev\central-issue-tracker
composer install
```

### Step 3: Verify Command Registration

```bash
php spark list | findstr "db:"
# or
php spark | grep "db:manager"
```

**Expected Output:** Should show `db:manager` command in Database group.

## Testing Procedures

### Test 1: Launch the CLI Menu

```bash
cd D:\dev\fullstack_dev\central-issue-tracker
php spark db:manager
```

**Expected Result:**
- Interactive menu should display with 10 options (0-9)
- Target database should show: `tps2015gh_issue_tracker`
- Export directory should show the path to `writable/exports`

### Test 2: Test MySQL Connection

**From the menu, select option [8]**

**Expected Result:**
- ✓ Success: "MySQL connection successful (Server: X.X.XX)"
- ✗ Failure: Error message with connection details

**If Connection Fails:**
1. Verify MySQL service is running:
   ```bash
   # Windows
   net start MySQL
   
   # Linux
   sudo systemctl status mysql
   ```

2. Check `.env` file credentials:
   ```
   database.default.hostname = localhost
   database.default.database = tps2015gh_issue_tracker
   database.default.username = root
   database.default.password =
   database.default.port = 3306
   ```

### Test 3: List All Databases

**From the menu, select option [2]**

**Expected Result:**
- Should list all user databases
- System databases (information_schema, mysql, etc.) should be filtered out
- Target database may or may not appear yet

### Test 4: Check Database Existence

**From the menu, select option [1]**

**Expected Result (First Run):**
- ✗ Database 'tps2015gh_issue_tracker' does NOT exist
- Suggestion to use option [3] to create it

### Test 5: Create Database

**From the menu, select option [3]**

**Steps:**
1. Confirm creation when prompted: `y`
2. Wait for success message

**Expected Result:**
- ✓ Database created successfully!
- Suggestion to use option [4] to run migrations

**Verify Manually:**
```bash
mysql -u root -e "SHOW DATABASES LIKE 'tps2015gh_issue_tracker';"
```

### Test 6: Initialize Database (Run Migrations)

**From the menu, select option [4]**

**Steps:**
1. Confirm migration when prompted: `y`
2. Wait for completion message

**Expected Result:**
- ✓ Migrations completed successfully.

**Verify Tables Created:**
```bash
mysql -u root tps2015gh_issue_tracker -e "SHOW TABLES;"
```

**Expected Tables:**
- projects
- issues
- users

### Test 7: Export Database

**From the menu, select option [5]**

**Steps:**
1. Confirm export when prompted: `y`
2. Note the generated filename

**Expected Result:**
- ✓ Database exported successfully to: `writable/exports/tps2015gh_issue_tracker_YYYYMMDD_HHMMSS.sql`
- File size displayed

**Verify Export File:**
```bash
# Windows
dir writable\exports\*.sql

# Linux/Mac
ls -la writable/exports/*.sql
```

### Test 8: List Export Files

**From the menu, select option [7]**

**Expected Result:**
- Should list all .sql files in exports directory
- Shows filename, size, and modification date

### Test 9: Import Database (Test Recovery)

**Prerequisites:** At least one export file must exist

**From the menu, select option [6]**

**Steps:**
1. Select file number from the list
2. Confirm import when prompted: `y` (WARNING: This will overwrite current data!)

**Expected Result:**
- ✓ Database imported successfully from: [filename]

**Verify Data:**
```bash
mysql -u root tps2015gh_issue_tracker -e "SELECT COUNT(*) FROM projects;"
mysql -u root tps2015gh_issue_tracker -e "SELECT COUNT(*) FROM issues;"
```

### Test 10: Switch Database Configuration

**From the menu, select option [9]**

**Available Presets:**
- `tps2015gh_issue_tracker` - TPS 2015 GH Issue Tracker (default)
- `central_issue_tracker` - Central Issue Tracker
- `win_audit` - Win Audit
- Custom database name

**Steps:**
1. Enter preset key or custom database name
2. Verify target database changed

**Expected Result:**
- ✓ Target database changed to: [new_name]

## Configuration Files

### `.env` File
Location: `D:\dev\fullstack_dev\central-issue-tracker\.env`

**Current Configuration:**
```
database.default.DBDriver = MySQLi
database.default.hostname = localhost
database.default.database = tps2015gh_issue_tracker
database.default.username = root
database.default.password = 
database.default.port = 3306
```

### `app/Config/Database.php`
Contains predefined configuration array for `tps2015gh` database connection.

## Troubleshooting

### Issue: Command Not Found

**Error:** `Command "db:manager" not found`

**Solutions:**
1. Verify `DatabaseManager.php` exists in `app/Commands/`
2. Clear CodeIgniter cache:
   ```bash
   php spark cache:clear
   ```
3. Check namespace in `DatabaseManager.php`:
   ```php
   namespace App\Commands;
   ```

### Issue: MySQL Connection Failed

**Error:** `MySQL connection failed: Access denied`

**Solutions:**
1. Verify MySQL credentials in `.env`
2. Test MySQL manually:
   ```bash
   mysql -u root -p
   ```
3. Check MySQL service status
4. Ensure port 3306 is not blocked

### Issue: Export Failed

**Error:** `Export failed: mysqldump: command not found`

**Solutions:**
1. Ensure MySQL bin directory is in PATH:
   ```bash
   # Windows (XAMPP)
   set PATH=%PATH%;C:\xampp\mysql\bin
   
   # Linux
   export PATH=$PATH:/usr/bin
   ```

2. Test mysqldump manually:
   ```bash
   mysqldump --version
   ```

### Issue: Permission Denied

**Error:** `Permission denied` when creating exports

**Solutions:**
1. Check directory permissions:
   ```bash
   # Windows
   icacls writable\exports
   
   # Linux/Mac
   ls -la writable/exports
   chmod 755 writable/exports
   ```

### Issue: Migration Failed

**Error:** Migration errors

**Solutions:**
1. Check migration file exists:
   ```bash
   dir app\Database\Migrations\*CreateCentralIssueTables.php
   ```

2. Rollback and retry:
   ```bash
   php spark migrate:rollback
   php spark migrate --all
   ```

3. Check migration status:
   ```bash
   php spark migrate:status
   ```

## Advanced Usage

### Batch Export Script

Create a batch file for quick exports:

**Windows (`quick_export.bat`):**
```batch
@echo off
cd /d D:\dev\fullstack_dev\central-issue-tracker
set TIMESTAMP=%date:~-4%%date:~3,2%%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%
set TIMESTAMP=%TIMESTAMP: =0%
mysqldump -u root tps2015gh_issue_tracker > writable\exports\backup_%TIMESTAMP%.sql
echo Export created: writable\exports\backup_%TIMESTAMP%.sql
pause
```

### Automated Daily Backup (Windows Task Scheduler)

Create a scheduled task to run daily:

**`daily_backup.bat`:**
```batch
@echo off
cd /d D:\dev\fullstack_dev\central-issue-tracker
for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%" & set "MN=%dt:~10,2%"
mysqldump -u root tps2015gh_issue_tracker > writable\exports\auto_%YYYY%%MM%%DD%_%HH%%MN%.sql
```

### Import Specific Table

To import only specific tables from an export file:

```bash
mysql -u root tps2015gh_issue_tracker --one-database < export.sql
```

## Performance Tips

1. **Large Database Exports:**
   - Use `--single-transaction` flag (already included)
   - Compress output: `mysqldump ... | gzip > backup.sql.gz`

2. **Fast Imports:**
   - Disable foreign key checks during import
   - Use `--quick` flag for large tables

3. **Regular Maintenance:**
   - Clean old export files periodically
   - Monitor `writable/exports/` directory size

## Support & Documentation

- **Main README:** `README_TRACKER.md`
- **Database Design:** `D:\dev\fullstack_dev\DababaseDesign.MD`
- **CodeIgniter Docs:** https://codeigniter.com/user_guide/

## Reporting Issues

If you encounter issues not covered in this guide:

1. Check application logs: `writable/logs/log-*.php`
2. Enable debug mode in `.env`: `database.default.DBDebug = true`
3. Review error messages from CLI output

## Next Steps

After successful testing:

1. Add sample data to test the web interface
2. Configure user authentication
3. Set up the web application: `php spark serve --port 8081`
4. Access at: `http://localhost:8081`

---

**Last Updated:** April 7, 2026
**Version:** 1.0
