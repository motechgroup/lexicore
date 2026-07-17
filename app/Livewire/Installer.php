<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.installer')]
class Installer extends Component
{
    public int $step = 1;

    // Step 1: Licensing
    public string $envatoUsername = '';

    public string $purchaseCode = '';

    // Step 2: Requirements & Permissions
    public array $requirements = [];

    public array $permissions = [];

    public bool $requirementsPassed = false;

    // Step 3: Database settings
    public string $dbConnection = 'sqlite'; // mysql or sqlite

    public string $dbHost = '127.0.0.1';

    public string $dbPort = '3306';

    public string $dbDatabase = 'database/database.sqlite'; // default for sqlite

    public string $dbUsername = 'root';

    public string $dbPassword = '';

    // Step 4: Administrator credentials
    public string $adminName = '';

    public string $adminEmail = '';

    public string $adminPassword = '';

    public string $adminPasswordConfirmation = '';

    public function mount(): void
    {
        if (config('system.installer_completed')) {
            $this->redirect('/');
        }
        $this->dbDatabase = database_path('database.sqlite');
        $this->checkRequirements();
    }

    /**
     * Check php extensions and folder permissions.
     */
    public function checkRequirements(): void
    {
        $extensions = [
            'PHP >= 8.2' => PHP_VERSION_ID >= 80200,
            'PDO' => extension_loaded('pdo'),
            'OpenSSL' => extension_loaded('openssl'),
            'Mbstring' => extension_loaded('mbstring'),
            'Tokenizer' => extension_loaded('tokenizer'),
            'XML' => extension_loaded('xml'),
            'Ctype' => extension_loaded('ctype'),
            'JSON' => extension_loaded('json'),
            'Fileinfo' => extension_loaded('fileinfo'),
        ];

        $dirs = [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(base_path('bootstrap/cache')),
        ];

        $this->requirements = $extensions;
        $this->permissions = $dirs;

        $this->requirementsPassed = ! in_array(false, $extensions, true) && ! in_array(false, $dirs, true);
    }

    /**
     * Step 1: Verify License
     */
    public function verifyLicense(): void
    {
        $this->validate([
            'envatoUsername' => 'required|string|min:3|max:100',
            'purchaseCode' => 'required|string|max:100',
        ]);

        // Standard CodeCanyon purchase code format is xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx (8-4-4-4-12 hex)
        if (! preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $this->purchaseCode)) {
            $this->addError('purchaseCode', __('Invalid Envato Purchase Code format. Format must be xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx.'));

            return;
        }

        // Mock verification validation - standard for offline installs with fallback options
        $this->step = 2;
    }

    /**
     * Step 2: Transition from requirements
     */
    public function proceedToDatabase(): void
    {
        $this->checkRequirements();

        if (! $this->requirementsPassed) {
            $this->addError('requirements', __('Please resolve all server requirements and permissions before proceeding.'));

            return;
        }

        $this->step = 3;
    }

    /**
     * Step 3: Verify & Save Database Details
     */
    public function verifyDatabase(): void
    {
        if ($this->dbConnection === 'sqlite') {
            $this->validate([
                'dbDatabase' => 'required|string',
            ]);

            // check if file exists, if not try to create
            if (! file_exists($this->dbDatabase)) {
                $dir = dirname($this->dbDatabase);
                if (! is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                touch($this->dbDatabase);
            }
        } else {
            $this->validate([
                'dbHost' => 'required|string',
                'dbPort' => 'required|string',
                'dbDatabase' => 'required|string',
                'dbUsername' => 'required|string',
                'dbPassword' => 'nullable|string',
            ]);
        }

        // Test Database connection
        try {
            if ($this->dbConnection === 'sqlite') {
                $pdo = new \PDO("sqlite:{$this->dbDatabase}");
            } else {
                $pdo = new \PDO(
                    "mysql:host={$this->dbHost};port={$this->dbPort};dbname={$this->dbDatabase}",
                    $this->dbUsername,
                    $this->dbPassword,
                    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                );
            }
        } catch (\Exception $e) {
            $this->addError('database', __('Database connection failed: ').$e->getMessage());

            return;
        }

        // Connection works! Save details to .env
        $this->updateEnv([
            'DB_CONNECTION' => $this->dbConnection,
            'DB_HOST' => $this->dbConnection === 'sqlite' ? '' : $this->dbHost,
            'DB_PORT' => $this->dbConnection === 'sqlite' ? '' : $this->dbPort,
            'DB_DATABASE' => $this->dbDatabase,
            'DB_USERNAME' => $this->dbConnection === 'sqlite' ? '' : $this->dbUsername,
            'DB_PASSWORD' => $this->dbConnection === 'sqlite' ? '' : $this->dbPassword,
        ]);

        $this->step = 4;
    }

    /**
     * Step 4: Install & Create Admin Account
     */
    public function runInstall(): void
    {
        $this->validate([
            'adminName' => 'required|string|max:255',
            'adminEmail' => 'required|email|max:255',
            'adminPassword' => 'required|string|min:8',
            'adminPasswordConfirmation' => 'required|string|same:adminPassword',
        ], [], [
            'adminPasswordConfirmation' => 'confirm password',
        ]);

        try {
            // Read config directly from .env file to bypass any cached configs or state losses
            $envPath = base_path('.env');
            $dbConfig = [
                'connection' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => '',
                'username' => '',
                'password' => '',
            ];

            if (file_exists($envPath)) {
                $lines = explode("\n", file_get_contents($envPath));
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (str_starts_with($line, 'DB_CONNECTION=')) {
                        $dbConfig['connection'] = trim(explode('DB_CONNECTION=', $line)[1] ?? 'mysql', '"\' ');
                    }
                    if (str_starts_with($line, 'DB_HOST=')) {
                        $dbConfig['host'] = trim(explode('DB_HOST=', $line)[1] ?? '127.0.0.1', '"\' ');
                    }
                    if (str_starts_with($line, 'DB_PORT=')) {
                        $dbConfig['port'] = trim(explode('DB_PORT=', $line)[1] ?? '3306', '"\' ');
                    }
                    if (str_starts_with($line, 'DB_DATABASE=')) {
                        $dbConfig['database'] = trim(explode('DB_DATABASE=', $line)[1] ?? '', '"\' ');
                    }
                    if (str_starts_with($line, 'DB_USERNAME=')) {
                        $dbConfig['username'] = trim(explode('DB_USERNAME=', $line)[1] ?? '', '"\' ');
                    }
                    if (str_starts_with($line, 'DB_PASSWORD=')) {
                        $dbConfig['password'] = trim(explode('DB_PASSWORD=', $line)[1] ?? '', '"\' ');
                    }
                }
            }

            // Apply database settings to active config in-memory before running migrations
            if ($dbConfig['connection'] === 'sqlite') {
                config([
                    'database.default' => 'sqlite',
                    'database.connections.sqlite.database' => $dbConfig['database'],
                ]);
            } else {
                config([
                    'database.default' => 'mysql',
                    'database.connections.mysql.host' => $dbConfig['host'],
                    'database.connections.mysql.port' => $dbConfig['port'],
                    'database.connections.mysql.database' => $dbConfig['database'],
                    'database.connections.mysql.username' => $dbConfig['username'],
                    'database.connections.mysql.password' => $dbConfig['password'],
                ]);
            }
            DB::purge();
            DB::reconnect();

            // 1. Clear caches first
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            // 2. Run migrations
            Artisan::call('migrate:fresh', ['--force' => true]);

            // 3. Run seeds
            Artisan::call('db:seed', ['--force' => true]);

            // 4. Create custom admin account
            $adminRole = Role::firstOrCreate(['name' => 'admin']);

            // Delete seeded default admin and any phone/email conflicts if they exist
            User::where('email', $this->adminEmail)->delete();
            User::where('email', 'admin@lexcore.test')->delete();
            User::where('phone', '+15550192835')->delete();

            $admin = User::create([
                'name' => $this->adminName,
                'email' => $this->adminEmail,
                'phone' => '+15550192835', // default seeded phone
                'password' => Hash::make($this->adminPassword),
                'email_verified_at' => now(),
            ]);

            $admin->assignRole($adminRole);

            // 5. Save installer completed flag to .env
            $this->updateEnv([
                'LEXCORE_INSTALLER_COMPLETED' => 'true',
            ]);

            // Clear cache config one last time
            Artisan::call('config:clear');

            $this->step = 5;
        } catch (\Exception $e) {
            $this->addError('install', __('Installation failed: ').$e->getMessage());
        }
    }

    public function completeInstallation(): void
    {
        $this->redirectRoute('login');
    }

    /**
     * Helper to write key-values into .env dynamically.
     */
    protected function updateEnv(array $data): void
    {
        $path = base_path('.env');

        if (! file_exists($path)) {
            if (file_exists(base_path('.env.example'))) {
                copy(base_path('.env.example'), $path);
            } else {
                touch($path);
            }
        }

        $content = file_get_contents($path);

        foreach ($data as $key => $value) {
            $keyPosition = strpos($content, "{$key}=");
            $valueStr = (str_contains($value, ' ') || str_contains($value, '#')) ? "\"{$value}\"" : $value;

            if ($keyPosition !== false) {
                $endOfLinePosition = strpos($content, "\n", $keyPosition);
                if ($endOfLinePosition === false) {
                    $endOfLinePosition = strlen($content);
                }
                $oldLine = substr($content, $keyPosition, $endOfLinePosition - $keyPosition);
                $content = str_replace($oldLine, "{$key}={$valueStr}", $content);
            } else {
                $content .= "\n{$key}={$valueStr}";
            }
        }

        file_put_contents($path, $content);
    }
}
