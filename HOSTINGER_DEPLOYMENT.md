# 🚀 Hostinger Deployment Guide - NuMinds Tech

## Your Setup
- **Folder Name:** `numindstech/appsite`
- **Hosting:** Hostinger
- **Domain:** Will point to `numindstech/appsite/public`

---

## Step 1: Access Hostinger Control Panel

1. Log in to Hostinger: https://hpanel.hostinger.com
2. Select your website
3. Go to **File Manager** or use **SSH/SFTP**

---

## Step 2: Set Up Folder Structure

### Option A: Using File Manager (Easier for beginners)
1. Go to **File Manager** in Hostinger panel
2. Navigate to `public_html`
3. Create folders:
   ```
   public_html/
   ├── numindstech/
   │   └── appsite/
   │       ├── public/          (web root - images, assets, uploads)
   │       ├── app/             (app logic)
   │       ├── admin/           (admin pages)
   │       ├── dbMigrationFiles/
   │       ├── storage/         (logs, uploads)
   │       ├── .env             (create manually)
   │       ├── .htaccess
   │       └── README.md
   ```

### Option B: Using SSH (Recommended)
```bash
# SSH into Hostinger
ssh username@your-server.com

# Navigate to public_html
cd public_html

# Create folder structure
mkdir -p numindstech/appsite
cd numindstech/appsite
```

---

## Step 3: Upload Your Files

### Option A: FTP/SFTP Upload
1. Open FileZilla or any FTP client
2. Connect using Hostinger SFTP credentials:
   - **Host:** your-server.com
   - **Port:** 22 (for SFTP) or 21 (for FTP)
   - **Username:** From Hostinger panel
   - **Password:** From Hostinger panel

3. Upload all files to: `/public_html/numindstech/appsite/`

### Option B: Git Clone (via SSH)
```bash
cd /home/username/public_html/numindstech/appsite

# Clone your repository
git clone https://your-github-repo.git .

# Or if already in folder
git clone https://your-github-repo.git temp
mv temp/* .
rm -rf temp
```

---

## Step 4: Configure Hostinger for Your Domain

### Point Domain to Public Folder

**In Hostinger cPanel:**

1. Go to **Addon Domains** or **Domains**
2. Add your domain pointing to: `public_html/numindstech/appsite/public`
3. **Or** set document root to: `/home/username/public_html/numindstech/appsite/public`

**In Hostinger hPanel (newer interface):**

1. Go to **Websites** → Your Site
2. Click **Settings** → **General**
3. Set **Document Root** to: `public_html/numindstech/appsite/public`

---

## Step 5: Create Production `.env` File

### Via Hostinger File Manager:
1. Go to File Manager → `numindstech/appsite/`
2. Create new file: `.env`
3. Add content:

```env
# Database Configuration (from Hostinger)
DB_HOST=localhost
DB_NAME=u970188659_numinds
DB_USER=u970188659_admin
DB_PASS=YOUR_STRONG_PASSWORD
BASE_URL=https://yourdomain.com
APP_ENV=production
```

### Via SSH:
```bash
nano .env
```

Paste the above content and press **Ctrl+X, then Y, then Enter**

---

## Step 6: Create/Import Database

### Via Hostinger cPanel → PhpMyAdmin:

1. **Create Database:**
   - Go to **MySQL Databases** or **Databases**
   - Create: `u970188659_numinds`
   - Create user: `u970188659_admin`
   - Assign all privileges

2. **Import Database:**
   - Go to **phpMyAdmin**
   - Select your database
   - Click **Import**
   - Upload your `numinds_db.sql` file
   - Click **Execute**

### Via SSH:
```bash
# Import database
mysql -u u970188659_admin -p u970188659_numinds < /home/username/numinds_db.sql
```

---

## Step 7: Set File Permissions

### Via SSH (Recommended):
```bash
cd /home/username/public_html/numindstech/appsite

# Set correct permissions
chmod 755 public
chmod 755 public/assets
chmod 755 public/uploads
chmod 755 storage
chmod 755 storage/logs
chmod 700 .env
chmod 755 app
chmod 755 admin

# Set ownership (if needed)
chown -R nobody:nobody public/uploads
chown -R nobody:nobody storage/logs
```

### Via File Manager:
1. Right-click each folder
2. Click **Permissions**
3. Set:
   - `public/uploads` → **755**
   - `storage/logs` → **755**
   - `.env` → **600** (if possible)

---

## Step 8: Enable SSL Certificate (HTTPS)

### Auto SSL (Hostinger)
1. Go to **SSL** section in Hostinger panel
2. Click **Manage SSL**
3. Select **Auto SSL** or **Let's Encrypt**
4. Click **Install**
5. Wait 5-10 minutes for activation

### Verify SSL:
```bash
https://yourdomain.com  # Should load with green lock
```

---

## Step 9: Redirect HTTP to HTTPS

### Edit `.htaccess` file

Update your `.htaccess` file in `numindstech/appsite/`:

```apache
<IfModule mod_rewrite.c>
RewriteEngine On

# HTTPS Redirect (uncomment this)
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}/numindstech/appsite/public/$1 [L,R=301]

# Or if domain points directly to public folder:
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Rest of your rules...
RewriteBase /numindstech/appsite/

Options -Indexes
ErrorDocument 404 /numindstech/appsite/public/404.php

# Block sensitive files
RewriteRule ^(app|storage|\.env|\.git) - [F,L]

# Clean URLs (if domain points to /public)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

---

## Step 10: Update Base URL Configuration

### Important for your setup:

Your folder structure means your base URL changes. Update:

**In `.env`:**
```env
# If domain points to: /numindstech/appsite/public
BASE_URL=/numindstech/appsite/public

# Or if you use subdomain pointing to /numindstech/appsite/public
BASE_URL=https://yourdomain.com
```

**In `app/config/app.php`**, it will automatically use this from `.env`

---

## Step 11: Test Your Deployment

### Check Everything Works

```bash
# Via SSH terminal:

# 1. Test PHP
php -v

# 2. Test database connection  
php app/core/DeploymentCheck.php

# 3. Check web access
curl https://yourdomain.com

# 4. Check logs for errors
tail -50 storage/logs/error.log
```

### Via Browser:
1. ✅ Visit **https://yourdomain.com** (should load home page)
2. ✅ Try **login page** (should load)
3. ✅ Try **login with credentials** (should work)
4. ✅ Upload a file (should save to `public/uploads/`)
5. ✅ Check dashboard (verify database works)

---

## Step 12: Verify Everything in Hostinger

### Via Hostinger File Manager or SSH:

```bash
# Check .env exists and is not readable from web
ls -la .env  # Should show -rw------- (600)

# Check directories are writable
ls -la public/uploads  # Should show drwxr-xr-x (755)
ls -la storage/logs    # Should show drwxr-xr-x (755)

# Check error logs
tail -20 storage/logs/error.log

# Check if database is connected
mysql -u u970188659_admin -p -e "use u970188659_numinds; SELECT COUNT(*) FROM users;"
```

---

## Common Hostinger Issues & Solutions

### Issue: "404 Not Found" on every page except home
**Solution:**
- Check `.htaccess` is uploaded
- Verify `mod_rewrite` is enabled (it is by default on Hostinger)
- Check RewriteBase matches your folder: `/numindstech/appsite/`

### Issue: "Cannot write to storage/logs"
**Solution:**
```bash
chmod 755 storage/logs
chmod 777 storage/logs  # If above doesn't work
```

### Issue: Database connection fails
**Solution:**
1. Verify credentials in `.env` match Hostinger MySQL
2. Verify database exists: `mysql -u user -p -e "SHOW DATABASES;"`
3. Check user has privileges: `mysql -u user -p database_name -e "SELECT 1;"`

### Issue: Images not loading
**Solution:**
- Check `BASE_URL` in `.env` is correct
- Verify file paths in public/uploads/
- Check .htaccess isn't blocking assets: `public/uploads/` should be accessible

### Issue: Email sending doesn't work
**Solution:**
- Hostinger has mail sending limits
- Check Hostinger → Email → Settings
- Use custom SMTP if provided

---

## After Going Live

### 1. Set Up Automated Backups
In Hostinger panel:
- Go to **Backups**
- Enable **Automatic Backups**
- Set schedule (daily recommended)

### 2. Monitor Error Logs
```bash
# SSH terminal - monitor live logs
tail -f storage/logs/error.log

# Or download via FTP and review
```

### 3. Create First Admin User (if needed)
```bash
# Via SSH, run migration
php dbMigrationFiles/migrate.php
```

### 4. Set Up Cron Job for Backups (Optional)
In Hostinger → **Advanced** → **Cron Jobs**:
```bash
0 2 * * * /usr/bin/php /home/username/public_html/numindstech/appsite/dbMigrationFiles/backup.php
```

---

## Your Final Checklist

Before marking as "Live":

- [ ] Domain points to: `/numindstech/appsite/public`
- [ ] SSL certificate installed and active (HTTPS working)
- [ ] `.env` file created with Hostinger database credentials
- [ ] Database imported successfully
- [ ] File permissions set (755 for folders, 600 for .env)
- [ ] Site loads with HTTPS
- [ ] Login works with credentials
- [ ] File uploads work
- [ ] No errors in `storage/logs/error.log`
- [ ] Automated backups enabled
- [ ] Admin password is strong (16+ characters)

---

## Support & Help

**Hostinger Support:**
- Live chat in hPanel (24/7)
- Ticket system (faster for complex issues)  
- Knowledge base: https://support.hostinger.com

**Common Hostinger Settings:**
- **SSH Username:** From Hostinger panel
- **FTP/SFTP Port:** 21 (FTP) or 22 (SFTP)
- **MySQL Host:** `localhost` (always)
- **phpMyAdmin:** hPanel → Databases → phpMyAdmin

---

## Quick Reference - Your URLs

```
Physical Folder: /home/username/public_html/numindstech/appsite/
Web Root:        /home/username/public_html/numindstech/appsite/public/
Public Uploads:  /home/username/public_html/numindstech/appsite/public/uploads/
Logs:            /home/username/public_html/numindstech/appsite/storage/logs/

Website URL:     https://yourdomain.com
Admin Panel:     https://yourdomain.com/dashboard
Login:           https://yourdomain.com/login
```

---

**You're all set! Your NuMinds Tech portal is ready for Hostinger.** 🚀

Questions? Check Hostinger support or review this guide section by section.
