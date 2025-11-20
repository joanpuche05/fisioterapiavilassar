<?php
// Router script for PHP built-in server to simulate .htaccess

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$decoded_uri = urldecode($uri);

// Serve static files if they exist
if (file_exists(__DIR__ . $decoded_uri) && $uri !== '/' && $uri !== '/index.php') {
    return false;
}

// Simulate RewriteRule ^es/?$ index.php?lang=es [QSA,L]
if (preg_match('/^\/es(\/|$)/', $uri)) {
    $_GET['lang'] = 'es';
    include __DIR__ . '/index.php';
    return;
}

// Default to index.php (Catalan)
include __DIR__ . '/index.php';
?>