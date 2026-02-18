# 🚀 Production Deployment Guide

## Pre-Deployment Checklist

### 1. **Code Security**
- [x] Remove hardcoded credentials from code
- [x] Environment variables configured in `.env` (not in git)
- [x] `.gitignore` protects `.env` and sensitive files
- [x] Debug files protected (hash.php, test files)
- [x] Error logging enabled (not displayed to users)

### 2. **Server Requirements**
- [ ] PHP 7.4 or higher
```bash
php -v
```

- [ ] MySQL 5.7+ or MariaDB 10.3+
```bash
mysql --version
```

- [ ] Apache with mod_rewrite enabled
```bash
apache2ctl -M | grep rewrite
```

- [ ] OpenSSL for HTTPS
- [ ] Git installed

### 3. **Database Setup**
```bash
# 1. Create production database
mysql -u root -p -e "CREATE DATABASE u970188659_numinds CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Create database user
mysql -u root -p -e "GRANT ALL PRIVILEGES ON u970188659_numinds.* TO 'u970188659_admin'@'localhost' IDENTIFIED BY 'YOUR_SECURE_PASSWORD'; FLUSH PRIVILEGES;"

# 3. Import database structure
mysql -u u970188659_admin -p u970188659_numinds < numinds_db.sql
```

### 4. **Server Deployment**

```bash
# 1. SSH into your server
ssh user@your-server.com

# 2. Navigate to web root
cd /var/www/html  # or /home/user/public_html

# 3. Clone repository
git clone https://your-github-repo-url.git numindsTech
cd numindsTech

# 4. Create production .env file
nano .env
```

**Production `.env` template:**
```env
DB_HOST=localhost
DB_NAME=u970188659_numinds
DB_USER=u970188659_admin
DB_PASS=YOUR_SECURE_PASSWORD
BASE_URL=https://yourdomain.com
APP_ENV=production
```

### 5. **File Permissions**
```bash
# Set proper permissions
chmod 755 public
chmod 755 public/assets
chmod 755 public/uploads
chmod 755 storage
chmod 755 storage/logs
chmod 700 .env

# Set ownership
chown -R www-data:www-data public/uploads
chown -R www-data:www-data storage/logs
```

### 6. **Web Server Configuration**

**Apache (with .htaccess):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    # Redirect HTTP to HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Block sensitive directories
    RewriteRule ^(app|storage|\.env) - [F,L]
    
    # Clean URLs
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/index.php?url=$1 [QSA,L]
</IfModule>

# Disable directory listing
Options -Indexes

# Security headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>
```

### 7. **SSL/HTTPS Setup**
```bash
# Using Let's Encrypt (recommended)
sudo certbot certonly --apache -d yourdomain.com

# Auto-renew
sudo certbot renew --dry-run
```

### 8. **Run Deployment Verification**
```bash
# Test deployment configuration
php app/core/DeploymentCheck.php
```

Expected output:
```
=== DEPLOYMENT CHECKLIST ===

✓ All critical checks passed!
```

### 9. **Post-Deployment Tests**

- [ ] **Home page loads** → https://yourdomain.com
- [ ] **Database connected** → Try login, check dashboard
- [ ] **File uploads work** → Try uploading an image
- [ ] **Logs are written** → Check storage/logs/
- [ ] **No PHP errors visible** → Check browser developer console
- [ ] **HTTPS redirects work** → Test http:// redirects to https://
- [ ] **API endpoints work** → Check form submissions
- [ ] **Rate limiting works** → Test login rate limits

### 10. **Backups & Monitoring**

Set up automated backups:
```bash
# Daily database backup
0 2 * * * mysqldump -u u970188659_admin -p'PASSWORD' u970188659_numinds > /home/user/backups/numinds_$(date +\%Y\%m\%d).sql
```

Monitor error logs:
```bash
# Real-time log monitoring
tail -f storage/logs/error.log

# Search for specific errors
grep -i "error\|exception" storage/logs/*.log
```

### 11. **Environment-Specific Updates**

**Update your `.env` values:**
- [ ] `BASE_URL` → Set to your domain
- [ ] `APP_ENV` → Change from "development" to "production"
- [ ] `DB_HOST`, `DB_USER`, `DB_PASS` → Production credentials
- [ ] Set strong passwords (minimum 16 characters with mixed case, numbers, symbols)

### 12. **Maintenance Mode (if needed)**

Toggle maintenance mode in admin panel:
```php
// Admin can set maintenance_mode setting to '1' to enable
```

Users will see maintenance page while development continues.

---

## Troubleshooting

### **"404 Not Found" errors**
- Check `.htaccess` is in place
- Verify mod_rewrite is enabled: `apache2ctl -M | grep rewrite`
- Check `BASE_URL` in `.env` matches your domain

### **"Database connection failed"**
- Verify `.env` credentials are correct
- Check database exists: `mysql -u root -p -e "SHOW DATABASES;"`
- Test connection: `mysql -u u970188659_admin -p -h localhost u970188659_numinds`

### **"Permission denied" on uploads folder**
- Check folder is writable: `ls -la | grep uploads`
- Fix with: `chmod 755 public/uploads && chown www-data:www-data public/uploads`

### **Images not loading**
- Check `BASE_URL` is correct
- Verify image paths in database
- Check browser console for 404 errors

---

## Security Hardening Checklist

- [ ] HTTPS enforced (redirect all HTTP to HTTPS)
- [ ] `.env` file is NOT committed to git
- [ ] Admin panel requires strong password (16+ chars)
- [ ] Rate limiting enabled on login/forms
- [ ] Database user has minimal required permissions
- [ ] Error messages don't expose system paths
- [ ] Logs don't contain sensitive information
- [ ] Regular backups tested (restore them monthly)
- [ ] Security updates applied (PHP, MySQL, packages)

---

## Rolling Back a Deployment

If something breaks:
```bash
git log --oneline  # Find last good commit
git revert <commit-hash>
git push origin main
# Pull on server and restart
```

---

## Getting Help

Check logs first:
```bash
tail -100 storage/logs/error.log
grep -i "error\|exception" storage/logs/*.log | tail -50
```

Document the error and contact support with:
- Last deployment time
- Last git commit
- Error log excerpt
- Steps to reproduce
