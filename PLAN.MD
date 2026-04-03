# Project Plan: WinAudit & Dashboard 2026

## Objective
Create a Go-based system auditing agent and a CodeIgniter 4 web application for monitoring and managing audit data.

## Team Roles
- **Lead Programmer:** Architecture design, core Go agent development, CI4 backend logic.
- **Tester E2E:** Writing and executing end-to-end tests (Cypress/Playwright).
- **QA:** Quality assurance, manual testing, UI/UX consistency, and documentation review.

## Phases

### Phase 1: Go Audit Agent
- Research `win-audit-2026` core functionalities.
- Implement Go modules for:
    - OS & System Info.
    - Hardware (CPU, RAM, Disk).
    - Network configuration.
    - Security (Firewall, AV status).
    - Installed Hotfixes/Updates.
- Output results to structured JSON.

### Phase 2: Web Application (CI4)
- Setup CodeIgniter 4 with SQLite.
- Implement User Authentication.
- Create Dashboard for server overview.
- Build "Upload Audit" functionality to process JSON files.
- Implement Server Management (Add/Edit/Remove).
- Implement Audit History (View/Delete).

### Phase 3: UI/UX & Themes
- Implement VS Code inspired dark/high-contrast theme.
- Add theme switching capability.
- Ensure responsive design for monitoring.

### Phase 4: Testing & QA
- Conduct E2E testing for the entire flow (Agent -> JSON -> Upload -> Dashboard).
- Bug fixes and performance optimization.

## Timeline (Estimated)
- Week 1: Agent Development & CI4 Setup.
- Week 2: Core Dashboard & Upload Logic.
- Week 3: UI Refinement & Theme Switching.
- Week 4: E2E Testing & Final QA.
