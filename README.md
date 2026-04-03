# WinAudit & Dashboard 2026

A modern, standalone Windows system auditing toolset. This project consists of two parts:
1.  **WinAudit Agent (Go):** A standalone executable to gather system data (OS, Hardware, Network, Security) and export to JSON.
2.  **WinAudit Dashboard (CodeIgniter 4):** A lightweight management app to upload audit JSONs, view server status, and track audit history with a VS Code-inspired UI.

---

## 🎬 Credits & Team

### Producer & Director
- **tps2015gh**: Vision, direction, and product ownership.

### Technical Architect & Implementation
- **Gemini CLI (AI Model)**: System architecture design, Go agent development, CI4 backend implementation, and UI/UX styling.

### Virtual Agent Team
- **Lead Programmer**: Architecture design, core Go agent development, CI4 backend logic.
- **Tester E2E**: Writing and executing end-to-end tests (Cypress/Playwright).
- **QA (Quality Assurance)**: Manual testing, UI/UX consistency, and documentation review.

---

## 📜 Team Policy
1.  **Security First**: Never log or commit sensitive data. Protect credentials and system configurations.
2.  **Validation-Driven**: Every implementation step must be followed by empirical verification.
3.  **Surgical Changes**: Only modify what is necessary for the task at hand.
4.  **Idiomatic Quality**: Adhere strictly to the conventions of each language (Go for the agent, PHP for the dashboard).
5.  **Simplicity over Complexity**: Prioritize robust, standalone solutions (like SQLite) over complex external dependencies.

---

## 💡 Technical Opinion (from Gemini CLI)
> "WinAudit 2026 represents an elegant balance between power and portability. By using **Go** for the agent, we achieve a high-performance, single-binary deployment that requires no runtime on target machines—a critical feature for security auditing. Choosing **CodeIgniter 4 with SQLite** for the dashboard provides a 'zero-config' management experience suitable for small teams or solo administrators.
>
> The VS Code-inspired UI isn't just aesthetic; it provides a familiar, high-contrast environment for technical users who need to process large amounts of system data quickly. This architecture is highly scalable for its intended scope and provides a solid foundation for future automated API-driven audit reporting."

---

## 🚀 Setup Instructions

### 1. Go Audit Agent
Ensure you have [Go](https://go.dev/) installed.
```bash
cd win-audit-agent
go build -o win-audit-agent.exe
./win-audit-agent.exe
```
This generates an `audit_[hostname]_[timestamp].json` file.

### 2. Dashboard (CI4)
Ensure you have **PHP 8.1+** and the **SQLite3** extension enabled.

> **⚠️ CRITICAL NOTE:** CodeIgniter 4 **ONLY** reads the file named exactly **`.env`** (with a leading dot). Files like `env`, `.env_sqlite`, or `.env_mysql` are just templates and will be ignored by the system until renamed to `.env`.

1. Install dependencies:
   ```bash
   cd win-audit-dashboard
   php composer.phar install
   ```
2. Setup environment:
   - **Environment Templates:**
     - To use **SQLite (Default)**: Copy `.env_sqlite` and rename it to **`.env`**.
     - To use **MySQL**: Copy `.env_mysql` and rename it to **`.env`**.
     - **Original CI4**: `.env_ci4` is a backup of the factory settings.
   - **Database Path Configuration (SQLite):**
     - **Lazy/Quick Start:** Set to your project root (easy to find):
       `database.default.database = D:\dev\fullstack_dev\win-audit-dashboard\database.sqlite`
     - **Advanced (Recommended):** Use the `writable` folder to keep the root clean and follow CI4 security standards:
       `database.default.database = D:\dev\fullstack_dev\win-audit-dashboard\writable\database.sqlite`
     - *Note: Always use absolute paths on Windows to avoid "Unable to open database" errors.*
3. Run migrations and seeder:
   ```bash
   php spark migrate
   php spark db:seed AdminSeeder
   ```
4. Start the server:
   ```bash
   php spark serve
   ```
5. Log in at `http://localhost:8080`:
   - **Username:** `admin`
   - **Password:** `password123`

---

## 🛠️ Troubleshooting: PHP Not Found

If you see an error like `'php' is not recognized as an internal or external command`, you need to locate the PHP executable manually.

### 1. Find PHP on Windows (CMD/PowerShell)
Try searching for the `php.exe` file using these commands:
```powershell
# Search using the 'where' command
where php.exe

# Deep search if not in PATH (may take a moment)
Get-ChildItem -Path C:\ -Filter php.exe -Recurse -ErrorAction SilentlyContinue
```

### 2. Common Paths (XAMPP/WAMP/PHP)
On standard Windows installations, PHP is usually located in:
- `C:\xampp-8-1-25\php\php.exe` (XAMPP versioned)
- `C:\xampp\php\php.exe` (Standard XAMPP)
- `C:\wamp64\bin\php\php[version]\php.exe` (WAMP)
- `C:\php\php.exe` (Manual install)

### 3. Add to Path Temporarily (PowerShell)
If you found the PHP directory (e.g., `C:\xampp\php\`), you can add it to your current PowerShell session's path to use the `php` command directly:
```powershell
# Replace the path with your actual PHP directory
$env:Path += ";C:\xampp\php\"

# Now you can run spark commands normally
php spark migrate
```

### 4. Usage with Absolute Path
Once found, you can also run commands by replacing `php` with the full path:
```bash
# Example: Running migrations with XAMPP PHP
C:\xampp\php\php.exe spark migrate
```

---

## 📦 Troubleshooting: Composer Not Found

If you see `Could not open input file: composer.phar`, it means the PHP command cannot find the `composer.phar` file in your current directory.

### 1. Use the Absolute Path
If you have `composer.phar` in the project root but are inside the `win-audit-dashboard` folder, use the path to the parent directory:
```powershell
# From win-audit-dashboard folder
php ..\composer.phar install
```

### 2. Move Composer to the App Folder
You can copy the `composer.phar` from the root into the dashboard folder:
```powershell
copy ..\composer.phar .
php composer.phar install
```

### 3. Download Composer Fresh
If the file is missing entirely, download it again using PHP:
```powershell
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
# Now run install
php composer.phar install
```

## 🛡️ License
MIT License (c) 2026. See [LICENSE](LICENSE) for details.
