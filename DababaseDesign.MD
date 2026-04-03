# Database Design: WinAudit Dashboard

## Database Engine: SQLite

## Tables

### 1. `users`
Stores information for authenticated users.
- `id`: INTEGER PRIMARY KEY AUTOINCREMENT
- `username`: TEXT UNIQUE NOT NULL
- `password`: TEXT NOT NULL (Hashed)
- `role`: TEXT DEFAULT 'user' ('admin', 'user')
- `created_at`: DATETIME DEFAULT CURRENT_TIMESTAMP
- `updated_at`: DATETIME DEFAULT CURRENT_TIMESTAMP

### 2. `servers`
Stores the current status of each audited server.
- `id`: INTEGER PRIMARY KEY AUTOINCREMENT
- `hostname`: TEXT UNIQUE NOT NULL
- `ip_address`: TEXT
- `os_name`: TEXT
- `os_version`: TEXT
- `cpu`: TEXT
- `ram_total`: TEXT
- `disk_info`: TEXT (JSON)
- `status`: TEXT ('online', 'offline', 'warning')
- `last_audit_at`: DATETIME
- `created_at`: DATETIME DEFAULT CURRENT_TIMESTAMP
- `updated_at`: DATETIME DEFAULT CURRENT_TIMESTAMP

### 3. `audit_history`
Stores a history of every upload from the Go agent.
- `id`: INTEGER PRIMARY KEY AUTOINCREMENT
- `server_id`: INTEGER
- `upload_date`: DATETIME DEFAULT CURRENT_TIMESTAMP
- `raw_json_path`: TEXT (Path to the stored JSON file)
- `summary`: TEXT (Brief summary of changes/status)
- FOREIGN KEY (`server_id`) REFERENCES `servers`(`id`) ON DELETE CASCADE

### 4. `settings`
Stores application configuration.
- `id`: INTEGER PRIMARY KEY AUTOINCREMENT
- `key`: TEXT UNIQUE NOT NULL
- `value`: TEXT
- `category`: TEXT ('theme', 'system', 'agent')

## Entity Relationship Summary
- A **User** manages multiple **Servers**.
- A **Server** has many **Audit History** entries.
- Each **Audit History** entry points to a physical JSON file on the server.
