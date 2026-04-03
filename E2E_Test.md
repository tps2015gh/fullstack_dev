# E2E Test Design: WinAudit Dashboard

## Objective
Verify the end-to-end flow from login to audit upload and server management using **Cypress** or **Playwright**.

## Test Suites

### 1. Authentication Suite
- **Login:** Verify that a user can log in with correct credentials.
- **Access Control:** Ensure unauthenticated users are redirected to the login page.
- **Logout:** Verify session termination and redirection.

### 2. Server Management Suite
- **Add Server:** Verify that a new server can be manually added.
- **Edit Server:** Verify that server details (e.g., hostname, IP) can be updated.
- **Delete Server:** Verify that a server and its associated history are removed correctly.

### 3. Audit Upload & Processing Suite
- **Upload Flow:**
    1. Select a valid `audit_sample.json`.
    2. Upload the file.
    3. Verify that the server status and stats (CPU, RAM, OS) on the dashboard are updated.
- **History Tracking:**
    - Verify that a new entry appears in the `audit_history` table after upload.
    - Verify that the history entry can be deleted.

### 4. UI/UX Suite
- **Theme Switcher:** Verify that clicking the theme toggle changes the UI background and text colors correctly.
- **Search & Filter:** Verify that the server list can be searched by hostname.
- **Responsiveness:** Ensure that the dashboard and server list are usable at different screen resolutions.

## Test Environment
- **Web App:** Running on local server (CI4 with SQLite).
- **Test Data:** A set of mock JSON files representing different server audit outputs.
- **Tools:** Playwright (Node.js) or Cypress.
