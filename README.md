# WinAudit & Dashboard 2026

A modern, standalone Windows system auditing toolset. This project consists of two parts:
1.  **WinAudit Agent (Go):** A standalone executable to gather system data (OS, Hardware, Network, Security) and export to JSON.
2.  **WinAudit Dashboard (CodeIgniter 4):** A lightweight management app to upload audit JSONs, view server status, and track audit history with a VS Code-inspired UI.

---

## 🎬 Credits & Team

### Producer & Director
- **DELL**: Vision, direction, and product ownership.

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
1. Install dependencies:
   ```bash
   cd win-audit-dashboard
   php composer.phar install
   ```
2. Setup environment:
   - Copy `env` to `.env`.
   - Configure `database.default.database = D:/absolute/path/to/writable/database.sqlite`.
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

## 🛡️ License
MIT License (c) 2026. See [LICENSE](LICENSE) for details.
