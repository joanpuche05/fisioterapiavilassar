<?php
// Set error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set UTF-8 encoding
header('Content-Type: text/html; charset=utf-8');

// Include helper functions
require_once __DIR__ . '/includes/functions.php';

// Detect language from URL parameter
// URL rewriting via .htaccess passes ?lang=es for /es requests
$lang = isset($_GET['lang']) && $_GET['lang'] === 'es' ? 'es' : 'ca';

// Load appropriate translations (default to Catalan)
$t = loadTranslations($lang);

// Include main template
include __DIR__ . '/includes/template.php';
?>