<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

// Clear OPCache compiled bytecode cache if active
if (function_exists('opcache_reset')) {
    opcache_reset();
}

// 1. Check/Create .env file and ensure safe drivers for installation
$envPath = __DIR__.'/../.env';
$envExamplePath = __DIR__.'/../.env.example';

$envCreated = false;
if (! file_exists($envPath)) {
    if (file_exists($envExamplePath)) {
        copy($envExamplePath, $envPath);
        $envCreated = true;
    } else {
        header('Content-Type: text/plain', true, 500);
        echo "ERROR: .env.example file not found!\n";
        exit;
    }
}

// Read and adjust environment settings natively before boot
$envContent = file_get_contents($envPath);
$replacements = [
    'SESSION_DRIVER=' => 'SESSION_DRIVER=file',
    'CACHE_STORE=' => 'CACHE_STORE=file',
    'QUEUE_CONNECTION=' => 'QUEUE_CONNECTION=sync',
];

$envLines = explode("\n", $envContent);
foreach ($replacements as $keyPrefix => $newValue) {
    $found = false;
    foreach ($envLines as $i => $line) {
        if (str_starts_with(trim($line), $keyPrefix)) {
            $envLines[$i] = $newValue;
            $found = true;
            break;
        }
    }
    if (! $found) {
        $envLines[] = $newValue;
    }
}

// Generate APP_KEY if empty or missing
$hasKey = false;
foreach ($envLines as $line) {
    if (str_starts_with(trim($line), 'APP_KEY=') && strlen(trim(explode('APP_KEY=', $line)[1] ?? '')) > 10) {
        $hasKey = true;
        break;
    }
}

if (! $hasKey) {
    $key = 'base64:'.base64_encode(random_bytes(32));
    $keyFound = false;
    foreach ($envLines as $i => $line) {
        if (str_starts_with(trim($line), 'APP_KEY=')) {
            $envLines[$i] = 'APP_KEY='.$key;
            $keyFound = true;
            break;
        }
    }
    if (! $keyFound) {
        $envLines[] = 'APP_KEY='.$key;
    }
}

file_put_contents($envPath, implode("\n", $envLines));

// Ensure SQLite database file exists
$dbFile = __DIR__.'/../database/database.sqlite';
if (! file_exists($dbFile)) {
    $dir = dirname($dbFile);
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    touch($dbFile);
}

// Load Composer Autoloader
$autoloader = __DIR__.'/../vendor/autoload.php';
if (! file_exists($autoloader)) {
    header('Content-Type: text/plain', true, 500);
    echo "ERROR: Vendor autoloader not found! Please upload your local 'vendor/' directory.\n";
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

if (function_exists('opcache_reset')) {
    echo "SUCCESS: Reset OPCache compiled bytecode cache.\n";
}

if ($envCreated) {
    echo "SUCCESS: Created .env file from .env.example\n";
} else {
    echo "INFO: .env file already exists.\n";
}

if (! $hasKey) {
    echo "SUCCESS: Generated and saved new APP_KEY.\n";
} else {
    echo "INFO: APP_KEY is already configured.\n";
}

echo "SUCCESS: Enforced safe SESSION_DRIVER=file, CACHE_STORE=file, and QUEUE_CONNECTION=sync in .env.\n";
echo "SUCCESS: Verified SQLite database file exists.\n";

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
