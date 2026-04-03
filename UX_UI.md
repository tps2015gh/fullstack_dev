# UX/UI Design: WinAudit Dashboard

## Visual Theme
- **Style:** VS Code inspired (Dark/High Contrast).
- **Primary Colors:**
    - Background: `#1e1e1e` (Default Dark), `#000000` (High Contrast)
    - Sidebar: `#252526`
    - Text: `#d4d4d4`
    - Accent (Success): `#4ec9b0`
    - Accent (Warning): `#ce9178`
    - Accent (Danger): `#f44747`
    - Links/Buttons: `#007acc`

## Theme Switching
- Toggle button in the top navbar to switch between **VS Code Dark**, **High Contrast**, and a **Light** theme for versatility.

## Layout Components

### 1. Navigation Sidebar
- Dashboard Icon (Overview)
- Servers Icon (Server List/Management)
- History Icon (Global Audit Logs)
- Settings Icon (Theme/Account)
- Logout (Bottom)

### 2. Dashboard Overview
- Summary Cards: Total Servers, Online/Offline, Last 24h Audits.
- Quick Search: By hostname or IP.
- Recent Audit Activities list.

### 3. Server Management
- List view with sorting (Hostname, Status, Last Audit).
- Action buttons: View Details, Edit Server, Delete.

### 4. Audit History Page
- Tabular data showing each upload.
- Actions: Download JSON, Delete record.
- Visual status indicators for changes detected in the audit.

## User Experience (UX)
- Simple standalone feel.
- Clean and minimal but with high contrast for readability.
- One-click navigation to core features.
- Persistent alerts for server failures or missing audits.
