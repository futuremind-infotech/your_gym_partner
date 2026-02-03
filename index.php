<?php
// Simple front controller proxy that forwards requests to the `public` folder.
// This is a convenience for environments where Apache isn't pointed at /public.

$public = __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.php';
if (! file_exists($public)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo "Missing public/index.php. Please ensure your project is intact or configure Apache DocumentRoot to point to the project's public/ folder.";
    exit;
}

// Proxy the request to public/index.php
require $public;
