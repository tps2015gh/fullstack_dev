# MySQL Database Startup Checklist

## Quick Start Guide for `tps2015gh_issue_tracker`

### Step 1: Verify MySQL is Running

**Windows (XAMPP):**
```bash
# Check if MySQL service is running
net start | findstr MySQL

# Or start MySQL from XAMPP Control Panel
# - Open XAMPP Control Panel
# - Click "Start" next to MySQL
```

**Windows (Standalone MySQL):**
```bash
net start MySQL80
# or
net start MySQL
```

**Verify Connection:**
```bash
mysql -u root -e "SELECT VERSION();"
```

### Step 2: Database Setup Options

#### Option A: Interactive CLI (RECOMMENDED)
```bash
cd D:\dev\fullstack_dev\central-issue-tracker
php spark db:manager
```

Then follow the menu:
1. Option [8] - Test MySQL Connection
2. Option [1] - Check if Database Exists
3. Option [3] - Create Database (if doesn't exist)
4. Option [4] - Initialize with Migrations
5. Option [5] - Export (Create Backup)

#### Option B: Manual Setup

**Create Database:**
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS tps2015gh_issue_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
```

**Verify Creation:**
```bash
mysql -u root -e "SHOW DATABASES LIKE 'tps2015gh_issue_tracker';"
```

**Run Migrations:**
```bash
cd D:\dev\fullstack_dev\central-issue-tracker
php spark migrate --all
```

**Verify Tables:**
```bash
mysql -u root tps2015gh_issue_tracker -e "SHOW TABLES;"
```

Expected tables:
- `projects`
- `issues`
- `users`

### Step 3: Start the Web Application

```bash
cd D:\dev\fullstack_dev\central-issue-tracker
php spark serve --port 8081
```

Access at: http://localhost:8081

### Step 4: Regular Maintenance

**Export Database (Backup):**
```bash
php spark db:manager
# Select option [5]
```

**Or use direct command:**
```bash
mysqldump -u root tps2015gh_issue_tracker > writable\exports\backup_%DATE%.sql
```

## Configuration Summary

### Database Credentials
- **Host:** localhost
- **Port:** 3306
- **User:** root
- **Password:** (blank)
- **Database:** tps2015gh_issue_tracker

### Files Modified
- ✅ `.env` - Updated to use `tps2015gh_issue_tracker`
- ✅ `app/Config/Database.php` - Added `tps2015gh` configuration
- ✅ `.env_mysql` - Updated template with new database name

### New Features Added
- ✅ Interactive CLI menu (`php spark db:manager`)
- ✅ Database helper functions
- ✅ Export/Import functionality
- ✅ Migration management
- ✅ Connection testing
- ✅ Database switching capability

## Troubleshooting Quick Reference

| Problem | Solution |
|---------|----------|
| MySQL not starting | Check XAMPP Control Panel, verify port 3306 not in use |
| Access denied | Verify credentials in `.env` file |
| Command not found | Run `composer install` |
| Migration failed | Check migration file exists, run `php spark migrate:status` |
| Export failed | Ensure `mysqldump` is in PATH |

## Environment Variables

Current `.env` configuration:
```
database.default.DBDriver = MySQLi
database.default.hostname = localhost
database.default.database = tps2015gh_issue_tracker
database.default.username = root
database.default.password = 
database.default.port = 3306
database.default.DBDebug = true
```

## Next Steps After Setup

1. ✅ Verify database is created and migrated
2. ✅ Test web application at http://localhost:8081
3. ✅ Create sample projects and issues
4. ✅ Set up regular export schedule
5. ✅ Configure authentication if needed

---

**Target Database:** `tps2015gh_issue_tracker`  
**Created:** April 7, 2026  
**Status:** Ready for Use
