<?php
/**
 * Logger Class
 * Logs important actions (especially admin actions) for audit trails
 */
class Logger {
    private static $logDir = __DIR__ . '/../../storage/logs';
    private static $logLevels = ['INFO', 'WARNING', 'ERROR', 'CRITICAL'];

    /**
     * Initialize logger (create logs directory if needed)
     */
    public static function init() {
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0755, true);
        }
    }

    /**
     * Log an information message
     */
    public static function info($message, $context = []) {
        self::log('INFO', $message, $context);
    }

    /**
     * Log a warning message
     */
    public static function warning($message, $context = []) {
        self::log('WARNING', $message, $context);
    }

    /**
     * Log an error message
     */
    public static function error($message, $context = []) {
        self::log('ERROR', $message, $context);
    }

    /**
     * Log a critical message
     */
    public static function critical($message, $context = []) {
        self::log('CRITICAL', $message, $context);
    }

    /**
     * Log admin action
     */
    public static function adminAction($userId, $action, $description, $details = []) {
        $context = array_merge([
            'user_id' => $userId,
            'user_ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'details' => $details
        ], $details);

        self::log('INFO', '[ADMIN ACTION] ' . $action . ': ' . $description, $context);
    }

    /**
     * Log security event
     */
    public static function security($event, $description, $context = []) {
        $securityContext = array_merge([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'timestamp' => date('Y-m-d H:i:s')
        ], $context);

        self::log('WARNING', '[SECURITY] ' . $event . ': ' . $description, $securityContext);
    }

    /**
     * Main logging function
     */
    private static function log($level, $message, $context = []) {
        self::init();

        $logFile = self::$logDir . '/' . date('Y-m-d') . '.log';
        
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' | ' . json_encode($context) : '';
        $logLine = "[$timestamp] [$level] $message$contextStr\n";

        file_put_contents($logFile, $logLine, FILE_APPEND);
    }

    /**
     * Get logs for a specific date
     */
    public static function getLogs($date = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        $logFile = self::$logDir . '/' . $date . '.log';
        
        if (!file_exists($logFile)) {
            return [];
        }

        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_reverse($lines); // Most recent first
    }

    /**
     * Search logs by keyword
     */
    public static function search($keyword, $days = 7) {
        $results = [];

        for ($i = 0; $i < $days; $i++) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $logs = self::getLogs($date);
            
            foreach ($logs as $log) {
                if (stripos($log, $keyword) !== false) {
                    $results[] = $log;
                }
            }
        }

        return $results;
    }

    /**
     * Get admin action logs
     */
    public static function getAdminActions($limit = 50) {
        $logs = self::getLogs();
        $adminLogs = [];

        foreach ($logs as $log) {
            if (strpos($log, '[ADMIN ACTION]') !== false) {
                $adminLogs[] = $log;
                if (count($adminLogs) >= $limit) {
                    break;
                }
            }
        }

        return $adminLogs;
    }

    /**
     * Get security event logs
     */
    public static function getSecurityLogs($limit = 50) {
        $logs = self::getLogs();
        $securityLogs = [];

        foreach ($logs as $log) {
            if (strpos($log, '[SECURITY]') !== false) {
                $securityLogs[] = $log;
                if (count($securityLogs) >= $limit) {
                    break;
                }
            }
        }

        return $securityLogs;
    }

    /**
     * Clear old logs (older than specified days)
     */
    public static function cleanup($daysToKeep = 30) {
        self::init();

        $cutoffTime = strtotime("-$daysToKeep days");
        $files = glob(self::$logDir . '/*.log');

        foreach ($files as $file) {
            if (filemtime($file) < $cutoffTime) {
                unlink($file);
            }
        }
    }
}
