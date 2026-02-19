<?php
/**
 * Root entry point for the NumindsTech project.
 *
 * This script serves two purposes:
 *
 * 1. **Web requests**
 *    The web server usually points to the `public/` directory.  If for some reason
 *    the document root is the project root (or someone visits the repo root via
 *    a browser), we simply redirect them into `public/index.php` so the application
 *    behaves exactly as before.
 *
 * 2. **CLI convenience**
 *    You can run quick commands from the project root without having to remember
 *    deep paths.  For example:
 *
 *        php index.php deploy      # run deployment checks
 *        php index.php migrate     # run database migrations
 *
 *    Feel free to expand the switch statement below with additional helpers
 *    (seeding, tests, etc.) as the project grows.
 */

// if we're running from the command line handle a few shortcuts
if (php_sapi_name() === 'cli') {
    $args = $_SERVER['argv'];
    array_shift($args); // drop script name

    $command = $args[0] ?? '';
    switch ($command) {
        case 'deploy':
            require __DIR__ . '/app/core/DeploymentCheck.php';
            break;
        case 'migrate':
            require __DIR__ . '/dbMigrationFiles/migrate.php';
            break;
        default:
            fwrite(STDOUT, "Usage: php index.php {deploy|migrate}\n");
            exit(1);
    }
    exit;
}

// for a web request simply forward into the public directory
header('Location: public/index.php');
exit;
