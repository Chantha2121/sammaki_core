<?php
// Debug environment variables
error_log('APP_KEY: ' . env('APP_KEY'));
error_log('APP_CIPHER: ' . env('APP_CIPHER'));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
