# 🚀 Hostinger Quick Deploy Commands

## SSH Access to Hostinger

```bash
# Connect via SSH (replace with your credentials from Hostinger panel)
ssh username@your-server-ip-or-domain

# Navigate to your app
cd public_html/numindstech/appsite
```

---

## 1️⃣ Initial Setup (Run Once)

```bash
# Create necessary directories
mkdir -p storage/logs
mkdir -p public/uploads

# Create .env file from template
cp .env.example .env

# Edit .env with your credentials
nano .env
# (Paste config, then Ctrl+X, Y, Enter)

# Set file permissions
chmod 700 .env
chmod 755 storage/logs
chmod 755 public/uploads
chmod 755 public

# Verify permissions
ls -la .env        # Should show: -rwx------ (700)
ls -la storage/logs # Should show: drwxr-xr-x (755)
```

---

## 2️⃣ Database Setup (First Time)

```bash
# Via SSH, create database and user
mysql -u root -p

# In MySQL prompt, run:
CREATE DATABASE u970188659_numinds CHARACTER SET utf8mb4;
CREATE USER 'u970188659_admin'@'localhost' IDENTIFIED BY 'YOUR_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON u970188659_numinds.* TO 'u970188659_admin'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Import your database
mysql -u u970188659_admin -p u970188659_numinds < numinds_db.sql
```

---

## 3️⃣ Verify Installation

```bash
# Check PHP version
php -v

# Test database connection
php -r "require 'app/config/db.php'; echo 'Database connected OK';"

# Run deployment checks
php app/core/DeploymentCheck.php

# Check error logs
tail -20 storage/logs/error.log

# Monitor logs in real-time
tail -f storage/logs/error.log
```

---

## 4️⃣ Update Code (After Development)

```bash
# Pull latest code from Git
git pull origin main

# Install dependencies (if using Composer)
composer install --no-dev

# Clear any cache
rm -rf storage/cache/*
```

---

## 5️⃣ Backup & Restore

### Backup Database
```bash
# Create backup
mysqldump -u u970188659_admin -p u970188659_numinds > numinds_backup_$(date +%Y%m%d).sql

# Download backup (via FTP or SFTP)
sftp username@your-server
get numinds_backup_*.sql
```

### Restore from Backup
```bash
# Restore database
mysql -u u970188659_admin -p u970188659_numinds < numinds_backup_20260218.sql
```

---

## 6️⃣ Troubleshooting Commands

```bash
# Check Apache modules (mod_rewrite)
apache2ctl -M | grep rewrite

# Test .htaccess syntax
apache2ctl -S

# Check disk space
df -h

# Check directory sizes
du -sh storage/
du -sh public/uploads/

# Find large files
find . -type f -size +50M

# Check PHP configuration
php -i | grep -E "memory_limit|upload_max_filesize|post_max_size"

# Display PHP errors
php -d display_errors=1 -r "phpinfo();"

# Check ownership (should be: nobody:nobody or www-data:www-data)
ls -la public/uploads
ls -la storage/logs
```

---

## 7️⃣ SSL Certificate (HTTPS)

```bash
# Check SSL certificate expiration
openssl s_client -connect yourdomain.com:443 -showcerts | grep -A4 "Issuer:"

# Test HTTPS redirect
curl -I http://yourdomain.com

# Should show: HTTP/1.1 301 Moved Permanently
# Location: https://yourdomain.com
```

---

## 8️⃣ Security Checks

```bash
# Verify .env is not accessible from web
curl https://yourdomain.com/.env  # Should return 403 Forbidden

# Verify app folder is not accessible
curl https://yourdomain.com/app/  # Should return 403 Forbidden

# Check file permissions match requirements
stat .env | grep -i "access:"
stat public/uploads | grep -i "access:"

# Scan for world-readable files (security risk)
find . -type f -perm -004
```

---

## 9️⃣ Performance Monitoring

```bash
# Monitor CPU and Memory in real-time
top

# Watch Apache processes
ps aux | grep apache | wc -l

# Check MySQL status
mysqladmin -u root -p status

# Analyze slow queries (if enabled)
tail -20 /var/log/mysql/slow-query.log

# Count active database connections
mysql -u root -p -e "SHOW PROCESSLIST;"
```

---

## 🔟 Advanced: Set Up Cron Job (Automatic Daily Backup)

```bash
# Edit crontab
crontab -e

# Add this line (runs daily at 2 AM)
0 2 * * * /usr/bin/mysqldump -u u970188659_admin -p'PASSWORD' u970188659_numinds > /home/username/backups/db_$(date +\%Y\%m\%d).sql

# List your cron jobs
crontab -l

# Remove all cron jobs (if needed)
crontab -r
```

---

## Common Issues & Quick Fixes

```bash
# Issue: Permission denied on storage/logs
sudo chown -R nobody:nobody public/uploads storage
chmod -R 755 public/uploads storage

# Issue: htaccess not working
# Check if file is there:
ls -la .htaccess

# Issue: Can't connect to database
# Verify user exists:
mysql -u root -p -e "SELECT user FROM mysql.user WHERE user='u970188659_admin';"

# Issue: Website showing blank page
# Check errors:
tail -100 storage/logs/error.log | grep -i error

# Issue: Uploads folder not writable
# Fix ownership:
chown -R www-data:www-data public/uploads
chmod 755 public/uploads
```

---

## Pro Tips 💡

1. **Always backup before updating:**
   ```bash
   mysqldump -u root -p mydb > backup_before_update.sql
   ```

2. **Monitor errors in real-time while testing:**
   ```bash
   tail -f storage/logs/error.log
   ```

3. **Keep a checklist of deployed features:**
   ```bash
   git log --oneline | head -20
   ```

4. **Test critical functions after deployment:**
   ```bash
   php app/core/DeploymentCheck.php
   ```

5. **Save bandwidth on backups (compress):**
   ```bash
   mysqldump -u root -p mydb | gzip > backup.sql.gz
   ```

---

## Your Custom Variables (Replace These)

| Variable | Value |
|----------|-------|
| `username` | _Your Hostinger SSH username_ |
| `your-server` | _Your Hostinger server IP/domain_ |
| `yourdomain.com` | _Your actual domain_ |
| `u970188659_admin` | _Your database username_ |
| `YOUR_STRONG_PASSWORD` | _Your database password (16+ chars)_ |

---

**Ready to deploy? Start with Section 1️⃣ and work through each section!** 🚀


RewriteEngine On

# If file or directory exists, serve it
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# Static Pages Routing
RewriteRule ^terms-and-conditions/?$ terms-and-conditions.php [L,QSA]
RewriteRule ^privacy-policy/?$ privacy-policy.php [L,QSA]
RewriteRule ^about-contact/?$ about-contact.php [L,QSA]
# Portfolio detail routing
RewriteRule ^portfolio-detail/([^/]+)$ portfolio-detail.php?key=$1 [L,QSA]

ErrorDocument 404 /404.php
