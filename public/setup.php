<?php

use App\Models\User;
use Dotenv\Dotenv;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

define('LARAVEL_START', microtime(true));

// Clear OPCache compiled bytecode cache if active
if (function_exists('opcache_reset')) {
    opcache_reset();
}

// Physically delete cached files to prevent configuration cache locks
$cacheFiles = [
    __DIR__.'/../bootstrap/cache/config.php',
    __DIR__.'/../bootstrap/cache/routes-v7.php',
    __DIR__.'/../bootstrap/cache/services.php',
    __DIR__.'/../bootstrap/cache/packages.php',
];
$deletedCaches = [];
foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        if (@unlink($file)) {
            $deletedCaches[] = basename($file);
        }
    }
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

// Check for one-click direct installation action parameter
if (isset($_GET['action']) && $_GET['action'] === 'install') {
    $email = $_GET['email'] ?? 'admin@admin.com';
    $password = $_GET['password'] ?? 'password';
    $name = $_GET['name'] ?? 'Admin';

    header('Content-Type: text/plain');
    echo "LexCore Standalone Database Installer\n";
    echo "=====================================\n\n";

    try {
        $dotenv = Dotenv::createMutable(base_path());
        $envData = $dotenv->load();

        $dbConnection = $envData['DB_CONNECTION'] ?? 'mysql';
        $dbHost = $envData['DB_HOST'] ?? '127.0.0.1';
        $dbPort = $envData['DB_PORT'] ?? '3306';
        $dbDatabase = $envData['DB_DATABASE'] ?? '';
        $dbUsername = $envData['DB_USERNAME'] ?? '';
        $dbPassword = $envData['DB_PASSWORD'] ?? '';

        echo "Connecting to Database: {$dbDatabase} on {$dbHost}...\n";

        if ($dbConnection === 'sqlite') {
            config([
                'database.default' => 'sqlite',
                'database.connections.sqlite.database' => $dbDatabase,
            ]);
        } else {
            config([
                'database.default' => 'mysql',
                'database.connections.mysql.host' => $dbHost,
                'database.connections.mysql.port' => $dbPort,
                'database.connections.mysql.database' => $dbDatabase,
                'database.connections.mysql.username' => $dbUsername,
                'database.connections.mysql.password' => $dbPassword,
            ]);
        }
        DB::purge();
        DB::reconnect();

        echo "Purging existing tables...\n";
        if ($dbConnection === 'sqlite') {
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            DB::statement('PRAGMA foreign_keys = OFF');
            foreach ($tables as $table) {
                DB::statement("DROP TABLE IF EXISTS `{$table->name}`");
            }
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            $tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE()');
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            foreach ($tables as $table) {
                DB::statement("DROP TABLE IF EXISTS `{$table->table_name}`");
            }
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
        echo 'SUCCESS: Purged '.count($tables)." tables.\n";

        echo "Running migrations...\n";
        Artisan::call('migrate:fresh', ['--force' => true]);
        echo "SUCCESS: Migrations completed.\n";

        echo "Running seeders...\n";
        Artisan::call('db:seed', ['--force' => true]);
        echo "SUCCESS: Seeders completed.\n";

        echo "Creating administrator account: {$email}...\n";
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        User::where('email', $email)->delete();
        User::where('email', 'admin@lexcore.test')->delete();
        User::where('phone', '+15550192835')->delete();

        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => '+15550192835',
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);
        echo "SUCCESS: Admin account created and assigned to 'admin' role.\n";

        echo "Locking installer...\n";
        // Edit .env file directly
        $envLines = explode("\n", file_get_contents($envPath));
        $found = false;
        foreach ($envLines as $i => $line) {
            if (str_starts_with(trim($line), 'LEXCORE_INSTALLER_COMPLETED=')) {
                $envLines[$i] = 'LEXCORE_INSTALLER_COMPLETED=true';
                $found = true;
                break;
            }
        }
        if (! $found) {
            $envLines[] = 'LEXCORE_INSTALLER_COMPLETED=true';
        }
        file_put_contents($envPath, implode("\n", $envLines));
        echo "SUCCESS: Installation completed and locked.\n";

        echo "\n=====================================\n";
        echo "Installation completed successfully! You can now log in at: /login\n";
        exit;
    } catch (Exception $e) {
        echo 'FATAL ERROR during installation: '.$e->getMessage()."\n";
        exit;
    }
}

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
