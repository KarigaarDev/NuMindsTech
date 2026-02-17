<?php
/**
 * SECURITY IMPROVEMENTS & IMPLEMENTATION GUIDE
 * 
 * This document outlines the security improvements made to the NuMinds Tech codebase.
 * 
 * ============================================================================
 * 1. INPUT VALIDATION (Validator Class)
 * ============================================================================
 * 
 * Location: app/core/Validator.php
 * 
 * The Validator class provides:
 * - Rule-based input validation
 * - Automatic sanitization
 * - Error collection and reporting
 * 
 * Available Validation Rules:
 * - required        → Field must have a value
 * - email           → Must be valid email format
 * - min:N           → Minimum length of N characters
 * - max:N           → Maximum length of N characters
 * - phone           → Valid phone number format
 * - url             → Valid URL format
 * - date            → Valid date in YYYY-MM-DD format
 * - numeric         → Must be numeric
 * - alpha           → Letters only
 * - alphanumeric    → Letters and numbers only
 * - match:field     → Must match another field value
 * 
 * Sanitization Methods:
 * - Validator::sanitizeString()  → Trim, stripslashes, escape
 * - Validator::sanitizeEmail()   → Filter and normalize email
 * - Validator::sanitizeUrl()     → Filter URL characters
 * - Validator::sanitizeNumber()  → Extract numeric characters
 * 
 * EXAMPLE USAGE IN LEADS FORM:
 * 
 *   $rules = [
 *       'name' => 'required|min:2|max:255',
 *       'email' => 'required|email',
 *       'phone' => 'required|phone',
 *       'message' => 'required|min:10|max:5000'
 *   ];
 * 
 *   if (!Validator::validate($_POST, $rules)) {
 *       $errors = Validator::errors();  // Get all errors
 *       $nameError = Validator::error('name');  // Get first error for field
 *       die('Validation failed');
 *   }
 * 
 * ============================================================================
 * 2. RATE LIMITING (RateLimiter Class)
 * ============================================================================
 * 
 * Location: app/core/RateLimiter.php
 * 
 * Prevents abuse through session and IP tracking.
 * 
 * Current Implementation:
 * - Login attempts: 5 per hour per IP
 * - Lead submissions: 3 per hour per IP
 * 
 * KEY METHODS:
 * 
 *   // Check if action is rate limited
 *   $limiter = new RateLimiter('login', 5, 3600);  // 5 attempts per 3600 seconds
 *   
 *   if ($limiter->isLimited()) {
 *       die('Too many attempts. ' . $limiter->getWaitMessage());
 *   }
 *   
 *   // Record an attempt after validation
 *   $limiter->recordAttempt();
 *   
 *   // Get remaining attempts
 *   echo $limiter->getRemaining();  // Returns int: 2
 *   
 *   // Get reset time in seconds
 *   echo $limiter->getResetTime();  // Returns int: 300
 *   
 *   // Reset rate limit (useful for successful login)
 *   $limiter->reset();
 * 
 * IMPLEMENTATION IN LOGIN PAGE:
 * 
 *   $rateLimiter = new RateLimiter('login', 5, 3600);
 *   
 *   if ($rateLimiter->isLimited()) {
 *       $error = 'Too many login attempts. ' . $rateLimiter->getWaitMessage();
 *   } else {
 *       // Validate, then record attempt on failure
 *       if (!$isValid) {
 *           $rateLimiter->recordAttempt();
 *       }
 *   }
 * 
 * ============================================================================
 * 3. SECURITY LOGGING (Logger Class)
 * ============================================================================
 * 
 * Location: app/core/Logger.php
 * 
 * Logs important events for audit trails and security monitoring.
 * 
 * Logs stored in: storage/logs/YYYY-MM-DD.log
 * 
 * LOG TYPES:
 * 
 *   Logger::info($message, $context)
 *   Logger::warning($message, $context)
 *   Logger::error($message, $context)
 *   Logger::critical($message, $context)
 *   Logger::adminAction($userId, $action, $description, $details)
 *   Logger::security($event, $description, $context)
 * 
 * EXAMPLES:
 * 
 *   // Log successful login
 *   Logger::info('User login successful', [
 *       'user_id' => $user['id'],
 *       'email' => $email,
 *       'ip_address' => $_SERVER['REMOTE_ADDR']
 *   ]);
 * 
 *   // Log failed login attempt
 *   Logger::security('LOGIN_FAILED', 'Invalid login attempt', [
 *       'email' => $email,
 *       'ip_address' => $_SERVER['REMOTE_ADDR']
 *   ]);
 * 
 *   // Log admin action
 *   Logger::adminAction($userId, 'DELETE_ITEM', 'Deleted portfolio item', [
 *       'item_id' => 123,
 *       'item_title' => 'Project Name'
 *   ]);
 * 
 *   // Log security event
 *   Logger::security('RATE_LIMIT_EXCEEDED', 'Lead submission limit exceeded', [
 *       'ip_address' => $_SERVER['REMOTE_ADDR']
 *   ]);
 * 
 * RETRIEVING LOGS:
 * 
 *   // Get all logs for today
 *   $logs = Logger::getLogs();  // Returns array of log lines
 *   
 *   // Get logs for specific date
 *   $logs = Logger::getLogs('2026-02-09');
 *   
 *   // Search logs
 *   $results = Logger::search('DELETE', 7);  // Last 7 days
 *   
 *   // Get only admin actions
 *   $adminLogs = Logger::getAdminActions(50);  // Last 50
 *   
 *   // Get only security events
 *   $securityLogs = Logger::getSecurityLogs(50);
 *   
 *   // Clean up old logs
 *   Logger::cleanup(30);  // Keep only last 30 days
 * 
 * ============================================================================
 * 4. SQL INJECTION PREVENTION
 * ============================================================================
 * 
 * All database queries use prepared statements with parameterized queries.
 * 
 * BEFORE (VULNERABLE):
 *   $pdo->exec("DELETE FROM users WHERE id = $userId");  // ❌ SQL INJECTION
 * 
 * AFTER (SECURE):
 *   $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
 *   $stmt->execute([$userId]);  // ✓ Parameterized Query
 * 
 * Fixed Files:
 * - setup_mock_data.php (lines 16, 22)
 * - migrate_client_portal.php (lines 46-47)
 * 
 * All controllers (BaseController, DashboardController, ClientPortalController,
 * LeadsController, PortfolioController) use prepared statements exclusively.
 * 
 * ============================================================================
 * 5. IMPLEMENTATION IN CONTROLLERS
 * ============================================================================
 * 
 * All admin actions are logged automatically in controller methods:
 * 
 * DashboardController:
 * - overview() → Displays dashboard (no logging needed)
 * 
 * ClientPortalController:
 * - index() → Displays client portal (no logging needed)
 * 
 * LeadsController:
 * - store($data) → Creates lead
 *   * Rate limiting: 3 per hour
 *   * Input validation
 *   * Input sanitization
 *   * Logged as info event
 * 
 * - addRemark($leadId, $remark) → Updates lead
 *   * Logged as admin action with remark preview
 * 
 * PortfolioController:
 * - create($data) → Creates portfolio item
 *   * Logged as admin action
 * 
 * - update($itemId, $data) → Updates portfolio item
 *   * Logged as admin action
 * 
 * - delete($itemId) → Deletes portfolio item
 *   * Logged as admin action with item details
 * 
 * ============================================================================
 * 6. SECURITY HEADERS (Recommended)
 * ============================================================================
 * 
 * Add to app/config/db.php or bootstrap file:
 * 
 *   header('X-Content-Type-Options: nosniff');
 *   header('X-Frame-Options: DENY');
 *   header('X-XSS-Protection: 1; mode=block');
 *   header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
 *   header('Content-Security-Policy: default-src self; script-src self cdn.tailwindcss.com cdn.jsdelivr.net cdnjs.cloudflare.com; style-src self cdn.tailwindcss.com fonts.googleapis.com');
 * 
 * ============================================================================
 * 7. PASSWORD BEST PRACTICES
 * ============================================================================
 * 
 * ✓ Currently implemented:
 * - Password hashing with PASSWORD_DEFAULT (bcrypt)
 * - Password_verify() for authentication
 * 
 * Recommended additions:
 * - Implement password reset functionality
 * - Enforce minimum password requirements (12+ characters, mixed case, numbers)
 * - Implement 2FA/MFA for admin users
 * - Add "remember me" token functionality
 * - Lock account after N failed login attempts
 * 
 * ============================================================================
 * 8. SESSION SECURITY
 * ============================================================================
 * 
 * ✓ Currently implemented:
 * - session_regenerate_id(true) on successful login
 * - CSRF token validation on all forms
 * - Session timeout (should be configured)
 * 
 * Recommended additions:
 * - Set session.cookie_httponly = 1 in php.ini
 * - Set session.cookie_secure = 1 for HTTPS
 * - Set session.cookie_samesite = Lax|Strict in php.ini
 * - Implement session timeout with activity tracking
 * 
 * ============================================================================
 * 9. TESTING SECURITY FEATURES
 * ============================================================================
 * 
 * RATE LIMITING:
 * - Submit login form 6 times in 1 hour → Should get rate limit error on 6th
 * - Submit lead form 4 times in 1 hour → Should get rate limit error on 4th
 * 
 * INPUT VALIDATION:
 * - Submit lead without email → Validation error
 * - Submit lead with invalid email → Validation error
 * - Submit lead with invalid phone → Validation error
 * - Submit lead with short message (< 10 chars) → Validation error
 * 
 * SQL INJECTION:
 * - Try to submit name: "'; DROP TABLE users; --"
 * - Should be safely escaped and stored as literal string
 * 
 * LOGGING:
 * - Check storage/logs/YYYY-MM-DD.log after actions
 * - Should see info, security, and admin action logs
 * 
 * ============================================================================
 * 10. MAINTENANCE
 * ============================================================================
 * 
 * Regular log cleanup (run weekly/monthly):
 *   Logger::cleanup(30);  // Keep last 30 days
 * 
 * Monitor security logs for suspicious activity:
 *   $securityLogs = Logger::getSecurityLogs(100);
 * 
 * Review admin action logs:
 *   $adminLogs = Logger::getAdminActions(100);
 * 
 * ============================================================================
