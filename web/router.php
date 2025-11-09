<?php
// Router script for PHP built-in web server to support pretty URLs
// Usage (from project root):
// php -S localhost:8080 -t web web/router.php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requested = __DIR__ . $uri;

// If the request is for an actual file (asset), let the built-in server handle it
if ($uri !== '/' && file_exists($requested)) {
    return false;
}

// Otherwise forward the request to index.php (Yii entry script)
require_once __DIR__ . '/index.php';
