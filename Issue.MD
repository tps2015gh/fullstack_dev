# Issue Tracking & Backlog: WinAudit Dashboard

## Known Issues
- **None:** Project is in the design phase.

## Current Backlog

### 1. Go Audit Agent
- [ ] Research and implement Windows-specific OS info collection (using `WMI` or `registry` libraries).
- [ ] Implement JSON schema for structured output.
- [ ] Add error handling for permissions and missing system tools.

### 2. CI4 Web App
- [ ] Setup CI4 project with Composer.
- [ ] Implement SQLite database migrations.
- [ ] Develop authentication filter for standalone access.
- [ ] Create basic Dashboard and Server listing views.

### 3. File Upload & Processing
- [ ] Develop JSON parser for agent outputs.
- [ ] Implement logic to update server records based on JSON content.
- [ ] Create `audit_history` record on each successful upload.

### 4. UI/UX & Themes
- [ ] Implement VS Code Dark theme (CSS).
- [ ] Add High Contrast theme option.
- [ ] Develop responsive sidebar navigation.

### 5. Potential Future Enhancements
- [ ] Automatic upload from agent (via API endpoint).
- [ ] Email/Slack notifications for server status changes.
- [ ] Comparison tool (diff) between audit versions for a single server.
- [ ] Export dashboard statistics as PDF or CSV.
- [ ] Multi-user with fine-grained permissions.
