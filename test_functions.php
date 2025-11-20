<?php
require_once 'includes/functions.php';

echo "Testing loadTranslations()...\n";
$ca = loadTranslations('ca');
$es = loadTranslations('es');

if ($ca['meta']['title'] && $es['meta']['title']) {
    echo "PASS: Translations loaded successfully.\n";
} else {
    echo "FAIL: Translations not loaded.\n";
}

echo "\nTesting get()...\n";
$title = get($ca, 'meta.title');
if ($title === "Axl Espai De Salut - Fisioteràpia a Vilassar de Mar") {
    echo "PASS: get() works correctly.\n";
} else {
    echo "FAIL: get() returned wrong value: $title\n";
}

echo "\nTesting e()...\n";
ob_start();
e('<script>alert(1)</script>');
$output = ob_get_clean();
if ($output === '&lt;script&gt;alert(1)&lt;/script&gt;') {
    echo "PASS: e() escapes HTML correctly.\n";
} else {
    echo "FAIL: e() did not escape correctly: $output\n";
}

echo "\nTesting asset()...\n";
// Mock SERVER vars
$_SERVER['HTTPS'] = 'on';
$_SERVER['HTTP_HOST'] = 'example.com';
$url = asset('css/style.css');
if ($url === 'https://example.com/css/style.css') {
    echo "PASS: asset() generates correct URL.\n";
} else {
    echo "FAIL: asset() returned: $url\n";
}
?>