<?php
/**
 * Google reCAPTCHA v3 Verification Helper
 */
class Recaptcha {
    private static $secretKey;

    /**
     * Set the secret key from settings
     */
    public static function setSecret($key) {
        self::$secretKey = $key;
    }

    /**
     * Verify the reCAPTCHA token
     * 
     * @param string $token The token sent from the frontend
     * @param string $action The expected action name
     * @param float $threshold Minimum score required (default 0.5)
     * @return bool
     */
    public static function verify($token, $action = 'lead_submission', $threshold = 0.5) {
        if (empty(self::$secretKey)) {
            // If reCAPTCHA is not configured, bypass check (fallback to honeypot/timer)
            return true;
        }

        if (empty($token)) {
            return false;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => self::$secretKey,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return false;
        }

        $result = json_decode($response, true);

        if ($result && $result['success'] && $result['score'] >= $threshold && $result['action'] === $action) {
            return true;
        }

        return false;
    }
}
