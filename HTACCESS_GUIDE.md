# 🔧 HTAccess Configuration Guide

## Your Setup: TWO Folder Levels

```
public_html/numindstech/appsite/        ← Root folder
├── .htaccess                           ← ROOT htaccess (blocks access to app/)
├── public/                             ← Web root
│   ├── .htaccess                       ← PUBLIC htaccess (routing)
│   ├── index.php                       ← Entry point
│   ├── assets/
│   ├── uploads/
│   └── 404.php
├── app/
├── admin/
├── storage/
├── .env
└── [other folders]
```

---

## 🎯 TWO DEPLOYMENT OPTIONS

### **OPTION 1: Domain Points to `/public` (RECOMMENDED)**

**Hostinger Setup:**
- Document Root: `/public_html/numindstech/appsite/public/`

**Files:**
- `.htaccess` → **IN** `/public/` folder ✓
- `index.php` → **IN** `/public/` folder ✓

**.htaccess Location:** `public/.htaccess`
```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Your clean URL routing
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

# Route all to index.php
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

**Access URLs:**
```
https://yourdomain.com              → /public/index.php ✓
https://yourdomain.com/login        → /public/login handler
https://yourdomain.com/assets/logo  → /public/assets/logo ✓
https://yourdomain.com/app/         → 403 Forbidden ✓
```

---

### **OPTION 2: Domain Points to `/numindstech/appsite` (LESS SECURE)**

**Hostinger Setup:**
- Document Root: `/public_html/numindstech/appsite/`

**Files:**
- `.htaccess` → **IN** Root folder
- `index.php` → **IN** `/public/` subfolder

**.htaccess Location:** (root) `.htaccess`
```apache
RewriteEngine On
RewriteBase /numindstech/appsite/

# Block sensitive folders
RewriteRule ^app/ - [F,L]
RewriteRule ^storage/ - [F,L]

# Redirect all to public folder
RewriteRule ^(.*)$ public/$1 [L]
```

**Access URLs:**
```
https://yourdomain.com                  → /public/index.php ✓
https://yourdomain.com/public/index.php → /public/index.php ✓
https://yourdomain.com/app/             → 403 Forbidden ✓
```

---

## ✅ WHICH ONE DO YOU HAVE?

**Find your Domain Root in Hostinger:**

1. Go to **Hostinger Panel** → **Websites**
2. Find your site → **Settings** → **General**
3. Look for **Document Root** field:

```
/home/username/public_html/numindstech/appsite/public/
                                                     ↑
                                    If it ends with /public/

Then use OPTION 1 (Recommended)
```

OR

```
/home/username/public_html/numindstech/appsite/
                                               ↑
                           If it ends without /public/

Then use OPTION 2
```

---

## 📝 UPDATE YOUR HOSTINGER SETUP

### **STEP 1: Verify Your Document Root**

Via Hostinger hPanel:
1. Go to **Websites**
2. Click your domain
3. Click **Settings** → **General**
4. Find **Document Root**

It should be ONE of these:

```
✓ GOOD: /home/u123456789/public_html/numindstech/appsite/public
✗ LESS SECURE: /home/u123456789/public_html/numindstech/appsite
```

### **STEP 2: Change Document Root (if needed)**

To change Document Root in Hostinger:

1. Go to **Websites** → Your Site
2. Click **Settings** → **General**
3. Find **Document Root** field
4. Change to: `/public_html/numindstech/appsite/public`
5. Click **Save**
6. Wait 5 minutes for changes to apply

---

## 🚀 WHICH HTACCESS FILES YOU NEED

### **For OPTION 1 (Recommended - Domain → `/public`):**

✓ **File 1:** `numindstech/appsite/public/.htaccess`
```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

Options -Indexes
RewriteRule ^(\.env|\.git) - [F,L]
RewriteRule ^app/ - [F,L]
RewriteRule ^storage/ - [F,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

✗ **File 2:** Root `.htaccess` **NOT NEEDED** (delete it)

---

### **For OPTION 2 (Domain → `/numindstech/appsite`):**

✓ **File 1:** `numindstech/appsite/.htaccess`
```apache
RewriteEngine On
RewriteBase /numindstech/appsite/

Options -Indexes
RewriteRule ^app/ - [F,L]
RewriteRule ^storage/ - [F,L]
RewriteRule ^admin/ - [F,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

RewriteRule ^(.*)$ public/$1 [L]
```

✗ **File 2:** `/public/.htaccess` **DELETE IT**

---

## 🔍 TEST YOUR SETUP

### After uploading `.htaccess`:

```bash
# Test that app folder is blocked
curl https://yourdomain.com/app/config/app.php
# Should return: 403 Forbidden ✓

# Test that .env is blocked
curl https://yourdomain.com/.env
# Should return: 403 Forbidden ✓

# Test that home page loads
curl https://yourdomain.com/
# Should return: 200 OK with HTML ✓

# Test that assets load
curl -I https://yourdomain.com/assets/hero-bg.png
# Should return: 200 OK ✓
```

---

## ⚠️ COMMON ISSUES & FIXES

### Issue: "404 Not Found" on all pages except home

**Cause:** Wrong `.htaccess` location or RewriteBase

**Fix:**
1. Verify `.htaccess` is in correct folder
2. Check RewriteBase matches your setup
3. Restart Apache: Contact Hostinger support

### Issue: Images/assets not loading

**Cause:** RewriteBase is wrong

**Fix:**
```apache
# If domain → /public only:
RewriteBase /

# If domain → /numindstech/appsite:
RewriteBase /numindstech/appsite/
```

### Issue: "mod_rewrite not enabled"

**Contact Hostinger Support:** They can enable it (it's standard on all hosting)

---

## 🎯 RECOMMENDED SETUP FOR HOSTINGER

**Best Practice:**
1. **Point domain to:** `/public_html/numindstech/appsite/public/`
2. **Use `.htaccess` in:** `public/` folder
3. **Delete or disable:** Root `.htaccess`

**Why?**
- ✓ More secure (app/ folder not web-accessible)
- ✓ Cleaner URLs
- ✓ Better performance
- ✓ Industry standard

---

## 📋 YOUR FINAL CHECKLIST

- [ ] Hostinger Document Root set to: `/public_html/numindstech/appsite/public/`
- [ ] `.htaccess` uploaded to: `public/` folder
- [ ] Root `.htaccess` deleted or moved
- [ ] Site loads: `https://yourdomain.com/` ✓
- [ ] App folder blocked: `https://yourdomain.com/app/` → 403 ✓
- [ ] Assets load: `https://yourdomain.com/assets/...` ✓
- [ ] Images load: `https://yourdomain.com/public/uploads/...` ✓

---

Done! Your setup is optimized for Hostinger with `index.php` in the `public/` folder. 🚀
