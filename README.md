# WinAudit & Dashboard 2026

A modern, standalone Windows system auditing toolset. This project consists of two parts:
1.  **WinAudit Agent (Go):** A standalone executable to gather system data (OS, Hardware, Network, Security) and export to JSON.
2.  **WinAudit Dashboard (CodeIgniter 4):** A lightweight management app to upload audit JSONs, view server status, and track audit history with a VS Code-inspired UI.

## License
MIT License (c) 2026. See [LICENSE](LICENSE) for details.

## Project Structure
- `win-audit-agent/`: Go source code for the auditor.
- `win-audit-dashboard/`: PHP CodeIgniter 4 web application.
- `PLAN.md`: Full project implementation plan.
- `DatabaseDesign.md`: SQLite schema details.
- `UX_UI.md`: Design specifications.

## Setup Instructions

### 1. Go Audit Agent
Ensure you have [Go](https://go.dev/) installed.
```bash
cd win-audit-agent
go build -o win-audit-agent.exe
./win-audit-agent.exe
```
This generates an `audit_[hostname]_[timestamp].json` file in the same directory.

### 2. Dashboard (CI4)
Ensure you have **PHP 8.1+** and the **SQLite3** extension enabled.
1. Install dependencies:
   ```bash
   cd win-audit-dashboard
   php composer.phar install
   ```
2. Setup environment:
   - Copy `env` to `.env`.
   - Configure `database.default.database = writable/database.sqlite`.
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

## Features
- **Agent:** zero-dependency gathering of OS info, CPU, RAM, Disk, Network, and Security (Firewall/AV).
- **Dashboard:** VS Code Dark/High-Contrast themes, upload/process JSON, server status overview, and audit history tracking.
- **Stand-alone:** Uses SQLite for easy deployment without external database servers.
