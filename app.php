<?php
// Load environment if not already loaded
if (!getenv('BASE_URL')) {
    $env_file = __DIR__ . '../../../.env';
    if (file_exists($env_file)) {
        $env_vars = parse_ini_file($env_file);
        foreach ($env_vars as $key => $value) {
            putenv("$key=$value");
        }
    }
}

return [
    'base_url' => getenv('BASE_URL') ?: '/numindsTech',
    'app_env' => getenv('APP_ENV') ?: 'development'
];
