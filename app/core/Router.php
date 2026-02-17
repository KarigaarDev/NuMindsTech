<?php
/**
 * Router Class - Handles routing, view rendering, and middleware
 */
class Router {
    private static $routes = [];
    private static $middlewares = [];
    private static $baseUrl = '';

    /**
     * Initialize router with base URL from config
     */
    public static function init($basePath = '') {
        self::$baseUrl = rtrim($basePath, '/');
    }

    /**
     * Simple view renderer - Extract data and require view file
     */
    public static function view($file, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $file . '.php';
    }

    /**
     * Register a GET route
     */
    public static function get($path, $callback) {
        self::registerRoute('GET', $path, $callback);
    }

    /**
     * Register a POST route
     */
    public static function post($path, $callback) {
        self::registerRoute('POST', $path, $callback);
    }

    /**
     * Register a route for multiple HTTP methods
     */
    public static function match($methods, $path, $callback) {
        foreach ((array)$methods as $method) {
            self::registerRoute(strtoupper($method), $path, $callback);
        }
    }

    /**
     * Register middleware for a path
     */
    public static function middleware($path, $callback) {
        if (!isset(self::$middlewares[$path])) {
            self::$middlewares[$path] = [];
        }
        self::$middlewares[$path][] = $callback;
    }

    /**
     * Register a single route
     */
    private static function registerRoute($method, $path, $callback) {
        $pattern = self::pathToPattern($path);
        if (!isset(self::$routes[$method])) {
            self::$routes[$method] = [];
        }
        self::$routes[$method][$pattern] = $callback;
    }

    /**
     * Convert path to regex pattern
     * /users/{id} => /users/(?P<id>\d+)
     */
    private static function pathToPattern($path) {
        $pattern = preg_replace_callback('/{(\w+)}/', function($matches) {
            return '(?P<' . $matches[1] . '>\w+)';
        }, $path);
        return '^' . preg_quote(self::$baseUrl . $path, '/') . '$';
    }

    /**
     * Match current request to a route
     */
    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Try to match route
        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $pattern => $callback) {
                if (preg_match('/' . $pattern . '/', $uri, $matches)) {
                    // Extract named groups
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    
                    // Run middlewares
                    foreach (self::$middlewares as $midPath => $midCallbacks) {
                        if (strpos($uri, $midPath) === 0) {
                            foreach ($midCallbacks as $middleware) {
                                $middleware();
                            }
                        }
                    }

                    // Call route callback
                    if (is_callable($callback)) {
                        call_user_func_array($callback, [$params]);
                    } elseif (is_string($callback)) {
                        self::view($callback, $params);
                    }
                    return;
                }
            }
        }

        // Route not found - trigger 404
        http_response_code(404);
        require __DIR__ . '/../../public/404.php';
    }

    /**
     * Generate URL with route parameters
     */
    public static function generateUrl($path, $params = []) {
        $url = $path;
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
        return self::$baseUrl . $url;
    }
}
