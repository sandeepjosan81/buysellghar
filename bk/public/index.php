<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Source - https://stackoverflow.com/a/58683309
// Posted by Ritesh
// Retrieved 2026-02-02, License - CC BY-SA 4.0




// Determine if the application is installed...
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if (! file_exists(__DIR__.'/../storage/installed')
    && ! str_starts_with($requestUri, '/install')
    && (stripos($_SERVER['REQUEST_URI'], '_debugbar') !== 1)) {
    header('Location: /install');
    exit;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());

 

