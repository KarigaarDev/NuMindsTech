<?php
/**
 * Input Validator Class
 * Provides comprehensive input validation and sanitization
 */
class Validator {
    private static $errors = [];

    /**
     * Validate and sanitize user inputs
     */
    public static function validate($data, $rules) {
        self::$errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $ruleArray = explode('|', $fieldRules);
            
            foreach ($ruleArray as $rule) {
                self::applyRule($field, $value, $rule, $data);
            }
        }
        
        return empty(self::$errors);
    }

    /**
     * Apply a validation rule
     */
    private static function applyRule($field, $value, $rule, $data) {
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $param = $ruleParts[1] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    self::addError($field, ucfirst($field) . ' is required');
                }
                break;

            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    self::addError($field, 'Invalid email format');
                }
                break;

            case 'min':
                if (!empty($value) && strlen($value) < $param) {
                    self::addError($field, ucfirst($field) . ' must be at least ' . $param . ' characters');
                }
                break;

            case 'max':
                if (!empty($value) && strlen($value) > $param) {
                    self::addError($field, ucfirst($field) . ' must not exceed ' . $param . ' characters');
                }
                break;

            case 'phone':
                if (!empty($value) && !self::isValidPhone($value)) {
                    self::addError($field, 'Invalid phone number format');
                }
                break;

            case 'url':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                    self::addError($field, 'Invalid URL format');
                }
                break;

            case 'date':
                if (!empty($value) && !self::isValidDate($value)) {
                    self::addError($field, 'Invalid date format (use YYYY-MM-DD)');
                }
                break;

            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    self::addError($field, ucfirst($field) . ' must be numeric');
                }
                break;

            case 'alpha':
                if (!empty($value) && !ctype_alpha($value)) {
                    self::addError($field, ucfirst($field) . ' can only contain letters');
                }
                break;

            case 'alphanumeric':
                if (!empty($value) && !ctype_alnum($value)) {
                    self::addError($field, ucfirst($field) . ' can only contain letters and numbers');
                }
                break;

            case 'match':
                if ($value !== ($data[$param] ?? null)) {
                    self::addError($field, ucfirst($field) . ' does not match ' . $param);
                }
                break;
        }
    }

    /**
     * Validate phone number
     */
    private static function isValidPhone($phone) {
        // Remove common phone separators
        $cleaned = preg_replace('/[\s\-\(\)]+/', '', $phone);
        return preg_match('/^\+?[0-9]{10,15}$/', $cleaned);
    }

    /**
     * Validate date format
     */
    private static function isValidDate($date) {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Sanitize string input
     */
    public static function sanitizeString($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeString'], $input);
        }
        return trim(stripslashes($input));
    }

    /**
     * Sanitize email
     */
    public static function sanitizeEmail($email) {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize URL
     */
    public static function sanitizeUrl($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize number
     */
    public static function sanitizeNumber($number) {
        return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Add validation error
     */
    private static function addError($field, $message) {
        self::$errors[$field][] = $message;
    }

    /**
     * Get validation errors
     */
    public static function errors() {
        return self::$errors;
    }

    /**
     * Get first error for a field
     */
    public static function error($field) {
        return self::$errors[$field][0] ?? null;
    }

    /**
     * Check if a specific field has errors
     */
    public static function hasError($field) {
        return isset(self::$errors[$field]);
    }
}
