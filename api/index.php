<?php

define('LARAVEL_START', microtime(true));

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: text/plain');
        echo "FATAL: {$error['message']}\n{$error['file']}:{$error['line']}\n";
    }
});

try {
    if (isset($_SERVER['VERCEL_REQUEST_URL'])) {
        $_SERVER['REQUEST_URI'] = $_SERVER['VERCEL_REQUEST_URL'];
    }

    if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
        require __DIR__.'/../storage/framework/maintenance.php';
    }

    require __DIR__.'/../vendor/autoload.php';

    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
