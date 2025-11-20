<?php
/**
 * Load translation file
 *
 * @param string $lang Language code (es, ca)
 * @return array Decoded JSON translations
 */
function loadTranslations($lang = 'es')
{
    $translationFile = __DIR__ . '/../translations/' . $lang . '.json';

    if (!file_exists($translationFile)) {
        // Fallback to Spanish if translation file not found
        $translationFile = __DIR__ . '/../translations/es.json';
    }

    $jsonContent = file_get_contents($translationFile);
    $translations = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error loading translations: ' . json_last_error_msg());
    }

    return $translations;
}

/**
 * Safe echo for HTML output (prevents XSS)
 *
 * @param string $string String to output
 * @return void
 */
function e($string)
{
    echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get nested array value using dot notation
 * Example: get($t, 'meta.title') returns $t['meta']['title']
 *
 * @param array $array Source array
 * @param string $key Dot-notated key
 * @param mixed $default Default value if key not found
 * @return mixed
 */
function get($array, $key, $default = '')
{
    $keys = explode('.', $key);

    foreach ($keys as $k) {
        if (!isset($array[$k])) {
            return $default;
        }
        $array = $array[$k];
    }

    return $array;
}

/**
 * Generate absolute URL for assets
 *
 * @param string $path Relative path
 * @return string Absolute URL
 */
function asset($path)
{
    // Remove leading slash if present
    $path = ltrim($path, '/');

    // Get protocol
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    // Get host
    $host = $_SERVER['HTTP_HOST'];

    // Return absolute URL
    // Encode path segments to handle spaces in filenames
    $pathSegments = explode('/', $path);
    $encodedPath = implode('/', array_map('rawurlencode', $pathSegments));

    return $protocol . '://' . $host . '/' . $encodedPath;
}

/**
 * Get base URL for the site
 *
 * @return string Base URL
 */
function baseUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . '://' . $host;
}
?>