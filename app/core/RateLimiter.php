<?php
/**
 * Rate Limiter Class
 * Implements rate limiting to prevent abuse of forms and login attempts
 * Uses session-based and IP-based tracking
 */
class RateLimiter {
    private $sessionKey;
    private $ipKey;
    private $maxAttempts;
    private $windowSeconds;

    /**
     * Constructor
     * 
     * @param string $action Unique identifier for the action (e.g., 'lead_submit', 'login')
     * @param int $maxAttempts Maximum attempts allowed in the time window
     * @param int $windowSeconds Time window in seconds
     */
    public function __construct($action, $maxAttempts = 5, $windowSeconds = 3600) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->sessionKey = 'rate_limit_' . $action;
        $this->ipKey = 'rate_limit_ip_' . $action;
        $this->maxAttempts = $maxAttempts;
        $this->windowSeconds = $windowSeconds;
    }

    /**
     * Check if action is rate limited
     * Returns true if user has exceeded the limit
     */
    public function isLimited() {
        $attempts = $this->getAttempts();
        return $attempts >= $this->maxAttempts;
    }

    /**
     * Record an attempt
     */
    public function recordAttempt() {
        $attempts = $this->getAttempts();
        $timestamp = time();

        $_SESSION[$this->sessionKey] = [
            'attempts' => $attempts + 1,
            'first_attempt' => $_SESSION[$this->sessionKey]['first_attempt'] ?? $timestamp,
            'last_attempt' => $timestamp
        ];
    }

    /**
     * Get number of attempts in current window
     */
    public function getAttempts() {
        if (!isset($_SESSION[$this->sessionKey])) {
            return 0;
        }

        $data = $_SESSION[$this->sessionKey];
        $elapsed = time() - $data['first_attempt'];

        // Reset if window has passed
        if ($elapsed > $this->windowSeconds) {
            unset($_SESSION[$this->sessionKey]);
            return 0;
        }

        return $data['attempts'] ?? 0;
    }

    /**
     * Get remaining attempts
     */
    public function getRemaining() {
        return max(0, $this->maxAttempts - $this->getAttempts());
    }

    /**
     * Get time until window resets (in seconds)
     */
    public function getResetTime() {
        if (!isset($_SESSION[$this->sessionKey])) {
            return 0;
        }

        $data = $_SESSION[$this->sessionKey];
        $elapsed = time() - $data['first_attempt'];
        $remaining = $this->windowSeconds - $elapsed;

        return max(0, $remaining);
    }

    /**
     * Reset rate limit for this action
     */
    public function reset() {
        unset($_SESSION[$this->sessionKey]);
    }

    /**
     * Get human-readable wait message
     */
    public function getWaitMessage() {
        $remaining = $this->getResetTime();
        
        if ($remaining <= 0) {
            return '';
        }

        if ($remaining < 60) {
            return 'Please try again in ' . round($remaining) . ' seconds.';
        }

        $minutes = ceil($remaining / 60);
        return 'Please try again in ' . $minutes . ' minute' . ($minutes > 1 ? 's' : '') . '.';
    }
}
