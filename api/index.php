<?php

// Redirect Laravel writable storage and compiled views to /tmp for Vercel serverless
$tmpDir = '/tmp';
putenv("APP_CONFIG_CACHE={$tmpDir}/config.php");
putenv("APP_EVENTS_CACHE={$tmpDir}/events.php");
putenv("APP_PACKAGES_CACHE={$tmpDir}/packages.php");
putenv("APP_ROUTES_CACHE={$tmpDir}/routes.php");
putenv("APP_SERVICES_CACHE={$tmpDir}/services.php");
putenv("VIEW_COMPILED_PATH={$tmpDir}/views");

// Enable debug mode temporarily to reveal exact Vercel exception
putenv("APP_DEBUG=true");

if (!is_dir("{$tmpDir}/views")) {
    @mkdir("{$tmpDir}/views", 0755, true);
}

// Forward Vercel serverless requests to Laravel front controller
require __DIR__ . '/../public/index.php';
