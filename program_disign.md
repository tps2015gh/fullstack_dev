# Program Design: WinAudit System

## 1. Go Audit Agent (Agent Tool)
The agent is a standalone Go binary compiled for Windows. It gathers system data and generates a JSON file.

### Architecture
- **Main Package:** Orchestrates the audit flow.
- **Module `sysinfo`:** Retrieves OS name, version, architecture, and uptime.
- **Module `hardware`:** Retrieves CPU info, total/free RAM, and disk partition stats.
- **Module `network`:** Collects IP addresses, MAC addresses, and active interfaces.
- **Module `security`:** Checks for installed Antivirus products and Firewall status.
- **Module `software`:** Lists installed hotfixes and major applications.
- **JSON Exporter:** Aggregates data into a standard JSON schema and writes to a file (e.g., `audit_[hostname]_[timestamp].json`).

## 2. CI4 Web Application (Management Dashboard)
The web app is built with CodeIgniter 4 and SQLite for lightweight management.

### Features
- **Authentication:** Single-user/small group login using `CodeIgniter\Shield` or a custom auth filter.
- **Dashboard:** Fetches server counts, status indicators, and recent audit activity from the database.
- **Server Controller:** Handles CRUD for server records.
- **Upload Controller:** Processes uploaded JSON files, updates the relevant server record, and saves an entry in `audit_history`.
- **History Controller:** View and delete individual audit logs.
- **Theme Manager:** Controller and assets (CSS) to toggle between dark/light/high-contrast modes stored in session/database.

## 3. Data Flow
1. **Agent Execution:** The Go agent runs on a target PC/Server and produces a JSON file.
2. **User Upload:** The user logs into the CI4 Dashboard and uploads the JSON file.
3. **Data Parsing:** CI4 parses the JSON and updates the `servers` table (latest state).
4. **History Archiving:** CI4 saves the audit timestamp and JSON path in `audit_history`.
5. **Real-time View:** The dashboard reflects the latest server status and updated statistics.
