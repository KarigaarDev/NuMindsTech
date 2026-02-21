# 📋 HOSTINGER DEPLOYMENT DAY CHECKLIST

**Project:** NuMinds Tech Portal  
**Folder:** `numindstech/appsite`  
**Date:** _______________  
**Deployed By:** _______________

---

## ✅ BEFORE DEPLOYMENT (Today - Home)

### Code Preparation
- [ ] All code committed to Git
- [ ] No debugging console.log() statements
- [ ] Database backup created locally
- [ ] `.env` file NOT in Git repository
- [ ] All tests pass locally
- [ ] Latest code pulled from repository

### Hostinger Account Prepared
- [ ] Hostinger account setup complete
- [ ] Domain purchased and pointed to hosting
- [ ] SSH credentials saved securely
- [ ] Backup location identified
- [ ] Support ticket number ready (if needed)

### Documentation Ready
- [ ] Database credentials noted (somewhere safe, not in email)
- [ ] Domain name: `________________`
- [ ] Database name: `u970188659_numinds`
- [ ] Database user: `u970188659_admin`
- [ ] Database password: `________________` (save securely!)
- [ ] FTP/SFTP credentials saved

---

## 🎯 DEPLOYMENT DAY EXECUTION

### Phase 1: Connect to Hostinger (15 min)

**Time Started:** ___________

```bash
# Step 1: SSH into Hostinger
ssh username@your-server.com

# Step 2: Navigate to web root
cd public_html

# Step 3: Create folder structure
mkdir -p numindstech/appsite
cd numindstech/appsite
```

- [ ] Successfully connected via SSH
- [ ] Folder `numindstech/appsite` created

**Time Completed:** ___________

---

### Phase 2: Upload Your Code (30 min)

**Time Started:** ___________

**Choose ONE method:**

#### Option A: Using Git (Recommended)
```bash
# Clone your repository
git clone https://your-github-url.git temp
mv temp/* .
rm -rf temp

# Verify files
ls -la
```

#### Option B: Using FTP/SFTP
Using FileZilla:
1. Connect to Hostinger SFTP
2. Navigate to: `/public_html/numindstech/appsite/`
3. Drag-and-drop all project files

#### Option C: Using SSH with tar
```bash
# From your local machine
tar czf numinds.tar.gz .
# Upload via FTP
# Then on Hostinger:
tar xzf numinds.tar.gz
rm numinds.tar.gz
```

- [ ] All files uploaded successfully
- [ ] Verify: `ls -la` shows: `app/`, `admin/`, `public/`, `.env.example`, etc.

**Time Completed:** ___________

---

### Phase 3: Database Setup (20 min)

**Time Started:** ___________

#### Via Hostinger cPanel:
1. Log in to cPanel/hPanel
2. Go to **MySQL Databases** (or **Databases**)
3. Create new database: `u970188659_numinds`
4. Create user: `u970188659_admin`
5. Assign ALL privileges
6. Note the password (save securely!)

#### Import Database:
1. Go to **phpMyAdmin**
2. Select your database
3. Click **Import**
4. Upload: `numinds_db.sql`
5. Click **Execute**

- [ ] Database created: `u970188659_numinds`
- [ ] Database user created with all privileges
- [ ] Database imported successfully
- [ ] Can query database: `SELECT COUNT(*) FROM users;`

**Time Completed:** ___________

---

### Phase 4: Configuration (15 min)

**Time Started:** ___________

```bash
# SSH into Hostinger
ssh username@your-server.com
cd public_html/numindstech/appsite

# Create .env file
nano .env
```

**Then copy and paste (update YOUR values):**
```env
DB_HOST=localhost
DB_NAME=u970188659_numinds
DB_USER=u970188659_admin
DB_PASS=YOUR_PASSWORD_HERE
BASE_URL=https://yourdomain.com
APP_ENV=production
```

Press: **Ctrl+X**, then **Y**, then **Enter**

- [ ] `.env` file created
- [ ] Database credentials entered correctly
- [ ] `BASE_URL` set to your domain
- [ ] `APP_ENV` set to `production`

**Time Completed:** ___________

---

### Phase 5: File Permissions (10 min)

**Time Started:** ___________

```bash
# SSH to Hostinger
ssh username@your-server.com
cd public_html/numindstech/appsite

# Set permissions
chmod 700 .env
chmod 755 storage
chmod 755 storage/logs
chmod 755 public
chmod 755 public/uploads
chmod 755 public/assets
chmod 755 app
chmod 755 admin

# Set ownership
chown -R nobody:nobody public/uploads
chown -R nobody:nobody storage/logs
```

- [ ] All permissions set correctly
- [ ] Verify: `ls -la` shows correct permissions
- [ ] `.env` is NOT readable by others

**Time Completed:** ___________

---

### Phase 6: Domain/SSL Configuration (20 min)

**Time Started:** ___________

**In Hostinger cPanel/hPanel:**

1. Go to **Addon Domains** or **Domains**
2. Set Document Root to: `/public_html/numindstech/appsite/public`
3. Or add domain pointing to that folder

4. Go to **SSL** section
5. Install **Auto SSL** or **Let's Encrypt**
6. Wait for activation (5-10 min)

**Test HTTPS:**
```bash
# From your computer
curl -I https://yourdomain.com

# Should show 200 OK with green lock
```

- [ ] Domain pointing to correct folder
- [ ] SSL certificate installed
- [ ] HTTPS accessible: `https://yourdomain.com`
- [ ] Browser shows green lock 🔒

**Time Completed:** ___________

---

### Phase 7: Verification Tests (20 min)

**Time Started:** ___________

```bash
# SSH into Hostinger
ssh username@your-server.com
cd public_html/numindstech/appsite

# Test 1: PHP version
php -v

# Test 2: Database connection
php -r "require 'app/config/db.php'; echo 'Database OK';"

# Test 3: Deployment checks
php app/core/DeploymentCheck.php

# Test 4: Check error logs
tail -20 storage/logs/error.log
```

**In Browser:**
1. Visit `https://yourdomain.com` → Should load home page ✓
2. Visit `https://yourdomain.com/login` → Should load login form ✓
3. Try login with test credentials → Should work ✓
4. Check dashboard → Should show data from database ✓
5. Try uploading a file → Should save to folder ✓

**Check for errors:**
- [ ] No 404 errors
- [ ] No database connection errors
- [ ] No permission errors
- [ ] No blank pages
- [ ] All images load
- [ ] CSS/JS load correctly

**Time Completed:** ___________

---

### Phase 8: Backups Setup (10 min)

**Time Started:** ___________

**In Hostinger hPanel:**
1. Go to **Backups** → **Automatic Backups**
2. Enable automatic backups
3. Set schedule: Daily (recommended)
4. Choose backup location

**Test Backup:**
```bash
# Create manual backup
mysqldump -u u970188659_admin -p u970188659_numinds > /home/username/backups/backup_test.sql
ls -lh /home/username/backups/
```

- [ ] Automatic backups enabled
- [ ] Manual backup created and verified
- [ ] Backup location confirmed

**Time Completed:** ___________

---

## ✅ POST-DEPLOYMENT (After Going Live)

### Immediate Tasks (Within 1 Hour)

- [ ] Verify site still loads after 30 minutes
- [ ] Check error logs for issues: `tail -50 storage/logs/error.log`
- [ ] Try key features again (login, upload, dashboard)
- [ ] Monitor for unusual activity

### Today's Tasks

- [ ] Send notification to stakeholders
- [ ] Document any issues encountered
- [ ] Save this checklist with times filled in
- [ ] Create backup copy of configuration

### First Week

- [ ] Monitor error logs daily
- [ ] Test all user workflows
- [ ] Verify automated backups are running
- [ ] Check performance/uptime
- [ ] Apply any critical security updates

### Ongoing

- [ ] Monthly backup verification
- [ ] Weekly error log review
- [ ] Quarterly security audit
- [ ] Annual database optimization

---

## 📝 DEPLOYMENT ISSUES LOG

### Issue 1
**Time Encountered:** ___________  
**Description:** _____________________________________________  
**Solution:** _____________________________________________  
**Resolved:** ☐ Yes ☐ No

### Issue 2
**Time Encountered:** ___________  
**Description:** _____________________________________________  
**Solution:** _____________________________________________  
**Resolved:** ☐ Yes ☐ No

### Issue 3
**Time Encountered:** ___________  
**Description:** _____________________________________________  
**Solution:** _____________________________________________  
**Resolved:** ☐ Yes ☐ No

---

## 🎉 DEPLOYMENT SUMMARY

**Deployment Started:** ___________  
**Deployment Completed:** ___________  
**Total Time:** ___________ hours

**Deployment Status:**
- ☐ Successful - Site is live and working
- ☐ Partial - Site is live with minor issues
- ☐ Failed - Rollback needed

**Issues Found:** _____  
**Issues Resolved:** _____  
**Outstanding Issues:** _____

**Sign Off By:** _____________________  
**Date:** _____________________

---

## 🆘 EMERGENCY CONTACTS

**Hostinger Support:** https://support.hostinger.com  
**Live Chat Available:** 24/7  
**Your Domain Registrar:** _________________________  
**Your Email:** _________________________  
**Backup Location:** _________________________

---

## 📚 REFERENCE LINKS

- Full Guide: See `HOSTINGER_DEPLOYMENT.md`
- Quick Commands: See `HOSTINGER_QUICK_COMMANDS.md`
- General Deployment: See `DEPLOYMENT.md`
- Architecture: See `ARCHITECTURE.md`

---

**CONGRATULATIONS! Your NuMinds Tech Portal is now live! 🚀**
