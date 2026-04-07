# 🚀 Quick Reference Card - Database Manager

## ⚡ ONE-LINE COMMANDS

```bash
# Launch Interactive Menu
php spark db:manager

# Or use the batch file (Windows)
start_db_manager.bat
```

---

## 📋 MENU OPTIONS CHEAT SHEET

```
┌──────────────────────────────────────────────────────────┐
│  [1] Check Database Exist    → Is database there?        │
│  [2] List All Databases      → Show all MySQL DBs        │
│  [3] Create Database         → Create if not exists      │
│  [4] Initialize Database     → Run migrations            │
│  [5] Export Database         → Backup to SQL file        │
│  [6] Import Database         → Restore from SQL file     │
│  [7] List Export Files       → View backups              │
│  [8] Test MySQL Connection   → Check connectivity        │
│  [9] Switch Database Config  → Change target DB          │
│  [0] Exit                    → Close manager             │
└──────────────────────────────────────────────────────────┘
```

---

## 🎯 FIRST-TIME SETUP (5 Steps)

```bash
# Step 1: Start MySQL
net start MySQL

# Step 2: Go to project
cd D:\dev\fullstack_dev\central-issue-tracker

# Step 3: Install dependencies (if needed)
composer install

# Step 4: Launch manager
php spark db:manager

# Step 5: In the menu:
#   → [8] Test Connection
#   → [3] Create Database
#   → [4] Initialize
#   → [5] Export (backup!)
```

---

## 🔧 COMMON TASKS

### Start Web App
```bash
php spark serve --port 8081
```
Then open: http://localhost:8081

### Create Backup
```bash
php spark db:manager → [5]
```

### Restore from Backup
```bash
php spark db:manager → [6]
```

### Check Database Status
```bash
php spark db:manager → [1]
```

---

## 📁 IMPORTANT FILES

| File | Purpose |
|------|---------|
| `.env` | Current database config |
| `app/Commands/DatabaseManager.php` | CLI menu code |
| `app/Helpers/database_helper.php` | Utility functions |
| `writable/exports/` | Backup storage |
| `README_TRACKER.md` | Full documentation |
| `DATABASE_MANAGER_GUIDE.md` | Testing guide |

---

## ⚙️ DATABASE CONFIG

```
Host:     localhost
Port:     3306
User:     root
Password: (blank)
Database: tps2015gh_issue_tracker
```

---

## 🆘 TROUBLESHOOTING

| Problem | Quick Fix |
|---------|-----------|
| PHP not found | Install PHP 8.1+ and add to PATH |
| MySQL not running | Start from XAMPP or `net start MySQL` |
| Command not found | Run `composer install` |
| Export failed | Check mysqldump in PATH |
| Permission denied | Check folder permissions |

---

## 📊 EXPORT FILES

**Location:** `writable/exports/`

**Naming:** `tps2015gh_issue_tracker_YYYY-MM-DD_HHMMSS.sql`

**List exports:**
```bash
dir writable\exports\*.sql
```

---

## 🎨 VISUAL INDICATORS

```
✓ Green  = Success
✗ Red    = Error
● Yellow = Warning/Info
─ Blue   = Separator
```

---

## 💡 PRO TIPS

1. **Always backup** before making changes
2. **Test connection first** (option 8)
3. **Check exports** regularly (option 7)
4. **Use confirmations** - they're there for safety!
5. **Log files** in `writable/logs/` for debugging

---

## 📚 FULL DOCS

- `README_TRACKER.md` - Complete project docs
- `DATABASE_MANAGER_GUIDE.md` - Detailed guide
- `MYSQL_STARTUP_CHECKLIST.md` - Startup steps
- `IMPLEMENTATION_SUMMARY.md` - What was built

---

**Quick Start:** Just run `php spark db:manager` and follow the menu! 🎉
