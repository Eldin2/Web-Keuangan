<?php

// Ensure all Laravel writable directories exist in /tmp for Vercel
$tmpStorage = '/tmp/storage';
putenv("APP_STORAGE={$tmpStorage}");
putenv("APP_CONFIG_CACHE={$tmpStorage}/framework/config.php");
putenv("APP_EVENTS_CACHE={$tmpStorage}/framework/events.php");
putenv("APP_PACKAGES_CACHE={$tmpStorage}/framework/packages.php");
putenv("APP_ROUTES_CACHE={$tmpStorage}/framework/routes.php");
putenv("APP_SERVICES_CACHE={$tmpStorage}/framework/services.php");
putenv("VIEW_COMPILED_PATH={$tmpStorage}/framework/views");

$dirs = [
    "{$tmpStorage}/framework/views",
    "{$tmpStorage}/framework/sessions",
    "{$tmpStorage}/framework/cache/data",
    "{$tmpStorage}/logs",
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Enable debug mode & fallback app key
putenv("APP_DEBUG=true");
if (!getenv("APP_KEY")) {
    putenv("APP_KEY=base64:tHPs6fhaJSsWFXA0/1kmLHrN/ercKZIttdYzz5Vdb0k=");
}

// Forward Vercel serverless requests to Laravel front controller
require __DIR__ . '/../public/index.php';
