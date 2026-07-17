<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

// Load Composer Autoloader
$autoloader = __DIR__.'/../vendor/autoload.php';
if (! file_exists($autoloader)) {
    header('Content-Type: text/plain', true, 500);
    echo "ERROR: Vendor autoloader not found! Please run 'composer install' or upload your local 'vendor/' directory.\n";
    exit;
}
require $autoloader;

// Bootstrap Laravel Application
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain');

echo "LexCore Deployment Tool\n";
echo "=======================\n\n";

// 1. Check/Create .env file
$envPath = __DIR__.'/../.env';
$envExamplePath = __DIR__.'/../.env.example';

if (! file_exists($envPath)) {
    if (file_exists($envExamplePath)) {
        copy($envExamplePath, $envPath);
        echo "SUCCESS: Created .env file from .env.example\n";
    } else {
        echo "ERROR: .env.example file not found!\n";
        exit;
    }
} else {
    echo "INFO: .env file already exists.\n";
}

// 2. Generate APP_KEY if empty
$envContent = file_get_contents($envPath);
$hasKey = false;
$lines = explode("\n", $envContent);
foreach ($lines as $line) {
    if (str_starts_with(trim($line), 'APP_KEY=') && strlen(trim(explode('APP_KEY=', $line)[1] ?? '')) > 10) {
        $hasKey = true;
    }
}

if (! $hasKey) {
    $key = 'base64:'.base64_encode(random_bytes(32));
    $keyFound = false;
    foreach ($lines as $i => $line) {
        if (str_starts_with(trim($line), 'APP_KEY=')) {
            $lines[$i] = 'APP_KEY='.$key;
            $keyFound = true;
        }
    }
    if (! $keyFound) {
        $lines[] = 'APP_KEY='.$key;
    }
    file_put_contents($envPath, implode("\n", $lines));
    echo "SUCCESS: Generated and saved new APP_KEY.\n";
} else {
    echo "INFO: APP_KEY is already configured.\n";
}

// 3. Create symbolic links
try {
    Artisan::call('storage:link');
    echo "SUCCESS: Created storage symbolic link.\n";
} catch (Exception $e) {
    echo 'WARNING: Could not create storage symlink: '.$e->getMessage()."\n";
}

// 4. Clear all caches
try {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    echo "SUCCESS: Cleared configuration, application, and view caches.\n";
} catch (Exception $e) {
    echo 'ERROR: Failed clearing caches: '.$e->getMessage()."\n";
}

echo "\n=======================\n";
echo "Deployment setup actions completed! You can now visit the homepage to run the installer.\n";
