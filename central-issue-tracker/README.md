# Central Issue Tracker - CodeIgniter 4 Application

## What is This Project?

This is a **Centralized Issue Tracker** built with CodeIgniter 4 to manage tasks, bug fixes, roadmaps, and user requests for multiple intranet applications in one place. It features a comprehensive **MySQL Database Management CLI** tool for easy database operations.

> **Database:** `tps2015gh_issue_tracker` | **User:** `root` | **Password:** (blank)

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.1 or higher with MySQL extensions
- MySQL/MariaDB server running
- Composer installed

### Installation

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Configure Environment:**
   - Copy `env` to `.env` (already done - `.env` is pre-configured)
   - Database is set to: `tps2015gh_issue_tracker`

3. **Setup Database (Interactive CLI):**
   ```bash
   php spark db:manager
   ```
   **Or use the batch file (Windows):**
   ```bash
   start_db_manager.bat
   ```
   
   **In the menu:**
   - `[8]` Test MySQL Connection
   - `[3]` Create Database (if not exists)
   - `[4]` Initialize with Migrations
   - `[5]` Export Database (create backup)

4. **Run Web Application:**
   ```bash
   php spark serve --port 8081
   ```

5. **Access at:** `http://localhost:8081`

---

## 📦 What's Included

### Core Features
- ✅ **Project Tracking** - Register and manage multiple intranet apps
- ✅ **Issue Classification** - Bug, Task, Plan, or Request
- ✅ **Priority & Status Management** - Track what's critical and what's completed
- ✅ **VS Code Dark Theme** - High-contrast UI for developers
- ✅ **MySQL Driven** - Real database for easy export and migration
- ✅ **CLI Database Manager** - Interactive command-line interface for all DB operations

### 🎯 Interactive CLI Menu (`php spark db:manager`)

**Database Operations:**
1. **Check Database Exist** - Verify if database exists
2. **List All Databases** - Show all MySQL databases
3. **Create Database** - Create `tps2015gh_issue_tracker` automatically
4. **Initialize Database** - Run migrations to create all tables
5. **Export Database** - Backup to SQL file with timestamp
6. **Import Database** - Restore from SQL backup
7. **List Export Files** - View available backup files
8. **Test MySQL Connection** - Verify database connectivity
9. **Switch Database Configuration** - Change target database

### 📁 New Files Created

| File/Directory | Purpose |
|----------------|---------|
| `app/Commands/DatabaseManager.php` | **Main CLI command** - Interactive menu system |
| `app/Helpers/database_helper.php` | **Database utilities** - Helper functions |
| `writable/exports/` | **Export storage** - Database backup files |
| `start_db_manager.bat` | **Quick start script** - Windows batch launcher |
| `QUICK_REFERENCE.md` | **Cheat sheet** - One-page command reference |
| `DATABASE_MANAGER_GUIDE.md` | **Testing guide** - Comprehensive usage instructions |
| `MYSQL_STARTUP_CHECKLIST.md` | **Startup checklist** - Step-by-step setup |
| `IMPLEMENTATION_SUMMARY.md` | **Implementation details** - What was built and why |

### 📝 Modified Files

| File | Changes |
|------|---------|
| `.env` | Updated to `tps2015gh_issue_tracker` database |
| `.env_mysql` | Added template with CLI documentation |
| `app/Config/Database.php` | Added `tps2015gh` connection preset |
| `README_TRACKER.md` | Complete rewrite with CLI features |

---

## 💻 CLI Commands Reference

### Database Manager
```bash
# Launch interactive database menu
php spark db:manager

# Or use Windows batch file
start_db_manager.bat
```

### Standard CodeIgniter Commands
```bash
# Run migrations
php spark migrate

# Check migration status
php spark migrate:status

# Rollback last migration
php spark migrate:rollback

# List all available commands
php spark list

# Clear cache
php spark cache:clear
```

---

## 🗄️ Database Configuration

### Target Database: `tps2015gh_issue_tracker`

**Connection Settings:**
```
Host:     localhost
Port:     3306
Database: tps2015gh_issue_tracker
Username: root
Password: (blank)
Charset:  utf8mb4
```

### Database Tables

1. **projects** - Project tracking
   - `id`, `name`, `description`, `status`, `created_at`, `updated_at`

2. **issues** - Issue management
   - `id`, `project_id`, `title`, `description`, `type`, `priority`, `status`, `due_date`, `created_at`, `updated_at`
   - Foreign key to `projects`

3. **users** - Authentication
   - `id`, `username`, `password`, `created_at`, `updated_at`

---

## 🔧 Database Helper Functions

The `app/Helpers/database_helper.php` provides reusable functions:

```php
check_database_exists($dbname)     // Check if database exists
list_databases()                   // List all MySQL databases
create_database($dbname)           // Create new database
export_database($dbname, $filepath) // Export to SQL file
import_database($dbname, $filepath) // Import from SQL file
run_migrations()                   // Execute CodeIgniter migrations
test_mysql_connection()            // Test database connectivity
get_export_files($dir)            // List export files
format_file_size($bytes)          // Human-readable file sizes
```

---

## 📚 Documentation Files

| File | Description |
|------|-------------|
| **`README_TRACKER.md`** | Complete project documentation with CLI features |
| **`DATABASE_MANAGER_GUIDE.md`** | Comprehensive testing and usage guide |
| **`MYSQL_STARTUP_CHECKLIST.md`** | Quick startup checklist |
| **`IMPLEMENTATION_SUMMARY.md`** | Implementation details and features |
| **`QUICK_REFERENCE.md`** | One-page cheat sheet for quick access |

---

## 🎨 Project Structure

```
central-issue-tracker/
├── app/
│   ├── Commands/
│   │   └── DatabaseManager.php          ✨ CLI database manager
│   ├── Controllers/
│   │   ├── Dashboard.php
│   │   ├── Projects.php
│   │   ├── Issues.php
│   │   └── ...
│   ├── Database/
│   │   └── Migrations/
│   │       └── 2026-04-07-050000_CreateCentralIssueTables.php
│   ├── Helpers/
│   │   └── database_helper.php          ✨ Utility functions
│   ├── Models/
│   └── Views/
├── writable/
│   ├── exports/                          ✨ Database backups
│   └── logs/
├── .env                                  ✏️ tps2015gh_issue_tracker
├── .env_mysql                            ✏️ MySQL template
├── README.md                             ✏️ This file
├── README_TRACKER.md                     ✏️ Full project docs
├── QUICK_REFERENCE.md                    ✨ Quick reference
├── DATABASE_MANAGER_GUIDE.md             ✨ Testing guide
├── MYSQL_STARTUP_CHECKLIST.md            ✨ Startup steps
├── IMPLEMENTATION_SUMMARY.md             ✨ Implementation details
└── start_db_manager.bat                  ✨ Windows launcher
```

---

## 🔍 Migration & Export

### Using CLI Tool (Recommended)

**Export Database:**
```bash
php spark db:manager → Select option [5]
```
Creates: `writable/exports/tps2015gh_issue_tracker_YYYY-MM-DD_HHMMSS.sql`

**Import Database:**
```bash
php spark db:manager → Select option [6]
```
Restores from selected SQL file

### Manual Export/Import

**Export:**
```bash
mysqldump -u root tps2015gh_issue_tracker > export.sql
```

**Import:**
```bash
mysql -u root tps2015gh_issue_tracker < export.sql
```

---

## 🛡️ Safety Features

- ✅ Confirmation prompts for destructive operations
- ✅ Non-blocking exports (`--single-transaction`)
- ✅ Error logging to `writable/logs/`
- ✅ Input validation
- ✅ Graceful error handling
- ✅ File existence checks before import
- ✅ Debug mode available in `.env`

---

## 🆘 Troubleshooting

| Problem | Solution |
|---------|----------|
| **MySQL not running** | Start MySQL service or XAMPP |
| **Command not found** | Run `composer install` |
| **Connection failed** | Check `.env` credentials |
| **Export failed** | Ensure `mysqldump` is in PATH |
| **Migration errors** | Run `php spark migrate:status` |

**Debug Mode:** Set `database.default.DBDebug = true` in `.env`

**Logs:** Check `writable/logs/log-*.php` for detailed errors

---

## 📊 Export File Management

**Location:** `writable/exports/`

**Filename Pattern:** `tps2015gh_issue_tracker_YYYY-MM-DD_HHMMSS.sql`

**List exports:**
```bash
dir writable\exports\*.sql   # Windows
ls writable/exports/*.sql    # Linux/Mac
```

---

## 🎯 Pro Tips

1. **Always backup** before making database changes
2. **Test connection first** using option [8]
3. **Use export files** for version-controlled backups
4. **Schedule regular backups** with Windows Task Scheduler
5. **Check migration status** before running migrations
6. **Use debug mode** when troubleshooting issues

---

## 📋 Quick Reference Card

```
┌──────────────────────────────────────────────────────────┐
│  QUICK COMMANDS                                          │
├──────────────────────────────────────────────────────────┤
│  Start Menu:     php spark db:manager                    │
│  Start Web:      php spark serve --port 8081             │
│  Backup:         Option [5] in menu                      │
│  Restore:        Option [6] in menu                      │
│  Test Connect:   Option [8] in menu                      │
│  Status:         Option [1] in menu                      │
└──────────────────────────────────────────────────────────┘
```

---

## 📖 Additional Resources

- **CodeIgniter 4 User Guide:** https://codeigniter.com/user_guide/
- **Full Project Documentation:** See `README_TRACKER.md`
- **Testing Guide:** See `DATABASE_MANAGER_GUIDE.md`
- **Quick Commands:** See `QUICK_REFERENCE.md`

---

## ⚙️ Environment Files

| File | Purpose |
|------|---------|
| `.env` | Active environment configuration |
| `.env_mysql` | MySQL configuration template |
| `.env_sqlite` | SQLite configuration (alternative) |
| `.env_ci4` | CodeIgniter 4 base configuration |

---

## 📝 Development Workflow

1. **Setup:** `composer install` → `php spark db:manager` → Create & migrate
2. **Develop:** Make changes, test locally
3. **Backup:** Export database before major changes
4. **Deploy:** Export → Copy files → Import on target → Update `.env`
5. **Maintain:** Regular exports, log monitoring

---

## 🎉 Summary

This Central Issue Tracker provides:
- ✅ Complete web-based issue management
- ✅ Interactive CLI for database operations
- ✅ Automated backup and restore
- ✅ Production-ready safety features
- ✅ Comprehensive documentation
- ✅ Easy migration between machines

**Get Started:** Run `php spark db:manager` and follow the menu!

---

**Database:** `tps2015gh_issue_tracker` | **Port:** 8081 | **Status:** ✅ Ready to Use
