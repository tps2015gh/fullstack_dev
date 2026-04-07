# Issue Tracking & Backlog: WinAudit Dashboard (Updated)

## Project Status: Beta/Functional Prototype
Most core features from Phase 1 and 2 are implemented. The system can now process audit JSON files, manage servers, and switch themes.

## Completed Tasks
- [x] Setup CI4 project with Composer.
- [x] Implement database migrations (Users, Servers, History, Settings).
- [x] Develop custom Authentication filter and login system.
- [x] Create Dashboard with summary statistics and recent audit cards.
- [x] Implement Server Management (CRUD).
- [x] Develop JSON parser for agent outputs in the Upload controller.
- [x] Implement VS Code inspired themes (Dark, Light, High Contrast).
- [x] Audit History tracking and raw JSON storage.

## Current Backlog & TODO List (For 1 Person)

### 1. Security & Validation Refinement
- [ ] **CSRF Protection:** Add `csrf_field()` to all remaining forms (`auth/login`, `server/add`, `upload/index`).
- [ ] **Input Validation:** Implement strict validation rules in `Server::save` and `Auth::login`.
- [ ] **Upload Security:** Add MIME type and file extension validation to `Upload::process` to ensure only `.json` files are accepted.
- [ ] **Password Management:** Create a profile page to allow the admin to change their password.

### 2. Feature Enhancements
- [ ] **API Endpoint for Agent:** Create a REST API endpoint (`POST /api/audit`) to allow the Go agent to push data automatically instead of manual upload.
- [ ] **Search & Filtering:** Add search bars to the Servers and History index pages.
- [ ] **Disk Usage Visualization:** Add a simple progress bar or small chart for disk usage in the Server Detail view.
- [ ] **Thai Language Support:** Implement translation files to support Thai language as per workspace standards.
- [ ] **Audit Diff Tool:** Add a feature to compare the current audit with the previous one to see what changed (e.g., new patches installed).

### 3. Reporting & Notifications
- [ ] **Dashboard Charts:** Integrate Chart.js to show trends in security patches or server status over time.
- [ ] **Export Data:** Add a "Download CSV/PDF" button for server lists and audit summaries.
- [ ] **Status Alerts:** Highlight servers that haven't been audited for more than 7 days.

### 4. Technical Debt & Cleanup
- [ ] **Refactor JSON Parsing:** Move the complex JSON processing logic from `Upload.php` and `Dashboard.php` into a dedicated Library or Service.
- [ ] **Outdated File Cleanup:** Remove or update `welcome_message.php` and other boilerplate CI4 files.
- [ ] **Documentation:** Update `README.md` with instructions on how to use the Go agent with the Dashboard.

## Low Priority / Future
- [ ] Multi-user support with roles.
- [ ] Slack/Email notifications for critical security counts.
- [ ] Automated cleanup of old JSON files in `writable/uploads/audits`.
