# Security Best Practices - Central Issue Tracker

## 🔒 Security Measures Implemented

### ✅ Current Security Features

1. **Environment-Based Configuration**
   - Database credentials in `.env` file (not version controlled)
   - `.env` properly listed in `.gitignore`
   - No hardcoded production credentials in source code

2. **Password Security**
   - Passwords hashed using PHP `password_hash()` with bcrypt
   - Password verification using `password_verify()`
   - No plain-text password storage in database

3. **Export File Protection**
   - Database exports stored in `writable/exports/`
   - Export directory excluded from git (`.gitignore`)
   - Timestamp-based filenames for audit trail

4. **Session Security**
   - Session data stored server-side
   - CSRF protection available (can be enabled in `.env`)

5. **Input Validation**
   - CodeIgniter's built-in validation
   - Parameter binding in database queries (SQL injection protection)

---

## 🛡️ Security Recommendations

### 🔴 CRITICAL - Must Do Before Production Use

1. **Change Default Admin Password**
   ```bash
   # After first login, change password immediately
   # Default password is set via SEEDER_DEFAULT_PASSWORD env var
   ```

2. **Set Strong Seeder Password**
   Add to `.env`:
   ```
   SEEDER_DEFAULT_PASSWORD=YourSecurePasswordHere!@#
   ```

3. **Enable CSRF Protection**
   In `.env`:
   ```
   app.CSRFProtection = true
   ```

4. **Enable CSP (Content Security Policy)**
   In `.env`:
   ```
   app.CSPEnabled = true
   ```

5. **Use Strong Database Password**
   - Never use blank passwords in production
   - Create dedicated database user with limited privileges
   ```sql
   CREATE USER 'tracker_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
   GRANT ALL PRIVILEGES ON tps2015gh_issue_tracker.* TO 'tracker_user'@'localhost';
   ```

6. **Set Production Environment**
   In `.env`:
   ```
   CI_ENVIRONMENT = production
   ```

### 🟡 IMPORTANT - Recommended

7. **Enable HTTPS**
   - Use SSL/TLS certificates
   - Force secure requests in `.env`:
     ```
     app.forceGlobalSecureRequests = true
     ```

8. **Secure Export Files**
   - Store exports outside web root
   - Set proper file permissions (750 for directories, 640 for files)
   - Regular cleanup of old backups

9. **Database Security**
   - Use non-root database user
   - Limit user privileges to minimum required
   - Enable MySQL audit logging

10. **Regular Updates**
    - Keep PHP updated to latest stable version
    - Update CodeIgniter 4 regularly
    - Monitor dependencies for vulnerabilities

### 🟢 BEST PRACTICES

11. **Access Control**
    - Implement role-based access control (RBAC)
    - Use strong password policies (min 12 chars, complexity)
    - Enable two-factor authentication (2FA)

12. **Logging & Monitoring**
    - Enable detailed logging in production:
      ```
      logger.threshold = 3  # Errors, warnings, info
      ```
    - Monitor `writable/logs/` regularly
    - Set up alerts for suspicious activities

13. **Backup Security**
    - Encrypt database exports:
      ```bash
      mysqldump ... | gpg --symmetric --cipher-algo AES256 > backup.sql.gpg
      ```
    - Store backups in secure, offsite location
    - Test backup restoration regularly

14. **Server Hardening**
    - Disable PHP error display in production
    - Set proper file permissions (644 for files, 755 for directories)
    - Disable directory listing
    - Use web application firewall (WAF)

15. **Code Security**
    - Never commit `.env` file
    - Use `.env.example` as template
    - Review code for security issues before deployment
    - Run static analysis tools (PHPStan, Psalm)

---

## 🚨 Security Checklist Before Deployment

- [ ] Changed default admin password
- [ ] Set strong `SEEDER_DEFAULT_PASSWORD`
- [ ] Enabled CSRF protection
- [ ] Enabled CSP
- [ ] Set `CI_ENVIRONMENT = production`
- [ ] Changed database credentials to strong password
- [ ] Created dedicated database user (not root)
- [ ] Enabled HTTPS
- [ ] Set proper file permissions
- [ ] Disabled debug/error display
- [ ] Configured logging
- [ ] Tested backup/restore procedures
- [ ] Reviewed and tested all security measures
- [ ] Documented security procedures for team

---

## 🔍 Audit Trail

### What Was Secured:

1. **Removed Hardcoded Credentials**
   - ❌ Removed: `admin / password123` from login view
   - ✅ Changed to: Environment variable with secure default

2. **Protected Export Files**
   - ❌ Not excluded before
   - ✅ Added to `.gitignore`: `writable/exports/*`

3. **Improved Seeder Security**
   - ❌ Was: Hardcoded `password123`
   - ✅ Now: Uses `env('SEEDER_DEFAULT_PASSWORD', 'secure_random')`

---

## 📋 Secure Deployment Template

Create `.env.example` for team members:

```env
# Copy this to .env and fill in your values
# NEVER commit .env to version control!

CI_ENVIRONMENT = development

# DATABASE - Use strong, unique credentials
database.default.DBDriver = MySQLi
database.default.hostname = localhost
database.default.database = tps2015gh_issue_tracker
database.default.username = your_db_user
database.default.password = your_strong_password_here
database.default.DBPrefix =
database.default.port = 3306
database.default.DBDebug = false

# SECURITY - Enable in production
# app.CSRFProtection = true
# app.CSPEnabled = true
# app.forceGlobalSecureRequests = true

# SEEDER - Set strong password for admin user
SEEDER_DEFAULT_PASSWORD=

# LOGGING
logger.threshold = 4
```

---

## 🆘 Security Incident Response

If you suspect a security breach:

1. **Immediate Actions**
   - Change all passwords (admin, database)
   - Review logs in `writable/logs/`
   - Check database for unauthorized changes
   - Revoke and regenerate any exposed credentials

2. **Investigation**
   - Review git history for unauthorized changes
   - Check export files for data exposure
   - Audit user accounts in database

3. **Recovery**
   - Restore from clean backup
   - Update all credentials
   - Enable additional security measures
   - Document incident and lessons learned

---

## 📚 Additional Resources

- [CodeIgniter 4 Security Documentation](https://codeigniter.com/user_guide/security/index.html)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [MySQL Security Guidelines](https://dev.mysql.com/doc/refman/8.0/en/security.html)

---

**Last Updated:** April 7, 2026  
**Status:** ✅ Basic security measures implemented  
**Next Step:** Follow recommendations before production deployment
