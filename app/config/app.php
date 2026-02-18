<?php
// Load environment
require_once __DIR__ . '/../core/Env.php';

return [
    'base_url' => Env::get('BASE_URL', '/numindsTech'),
    'app_env' => Env::get('APP_ENV', 'development')
];
