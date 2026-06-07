<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (isset($_SERVER['VERCEL_REQUEST_URL'])) {
    $_SERVER['REQUEST_URI'] = $_SERVER['VERCEL_REQUEST_URL'];
}

// Serve static files directly from public/ before booting Laravel
$publicPath = __DIR__ . '/../public';
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($requestUri !== '/' && $requestUri !== '') {
    $filePath = $publicPath . $requestUri;
    $realPath = realpath($filePath);

    if ($realPath !== false && str_starts_with($realPath, realpath($publicPath)) && is_file($realPath)) {
        $ext = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'avif' => 'image/avif',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'otf' => 'font/otf',
            'txt' => 'text/plain',
            'pdf' => 'application/pdf',
            'json' => 'application/json',
        ];

        header('Content-Type: ' . ($mimeTypes[$ext] ?? 'application/octet-stream'));
        header('Content-Length: ' . filesize($realPath));
        header('Cache-Control: public, max-age=31536000, immutable');
        readfile($realPath);
        exit;
    }
}

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
