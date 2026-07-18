<?php

/**
 * LexCore Admin Recovery / Creation Script for Shared Hosting
 *
 * For security reasons, please delete this file from your public folder immediately after running it.
 */

// Define a secret key to prevent unauthorized access.
// Access the script via: https://yourdomain.com/create_admin.php?secret=lexcore_admin_9938_recovery&email=admin@lexcore.test&password=YourNewPassword
$securitySecret = 'lexcore_admin_9938_recovery';

if (empty($_GET['secret']) || $_GET['secret'] !== $securitySecret) {
    http_response_code(403);
    exit('Forbidden: Invalid or missing security token.');
}

define('LARAVEL_START', microtime(true));

// Load Composer Autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel Application
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$response = $kernel->handle(
    $request = Request::capture()
);

use App\Models\User;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

$email = $_GET['email'] ?? 'admin@lexcore.test';
$password = $_GET['password'] ?? 'password';
$name = $_GET['name'] ?? 'System Administrator';

try {
    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]
    );

    // If the user already exists, override password and name
    $user->update([
        'name' => $name,
        'password' => Hash::make($password),
    ]);

    // Ensure core admin role exists
    $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

    // Assign role
    $user->assignRole($adminRole);

    echo "<div style='font-family: sans-serif; max-width: 500px; margin: 40px auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color: #059669; margin-top: 0;'>Success! Admin Configured</h2>";
    echo "<p style='font-size: 14px; color: #475569;'>Your administrative account has been successfully configured and verified.</p>";
    echo "<hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;' />";
    echo "<p style='font-size: 13px;'><strong>Profile Name:</strong> {$name}</p>";
    echo "<p style='font-size: 13px;'><strong>Email:</strong> {$email}</p>";
    echo "<p style='font-size: 13px;'><strong>Password:</strong> {$password}</p>";
    echo "<hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;' />";
    echo "<p style='font-size: 12px; color: #dc2626; font-weight: bold;'>CRITICAL SECURITY WARNING: Delete this 'create_admin.php' file from your public directory immediately!</p>";
    echo '</div>';

} catch (Exception $e) {
    echo "<div style='font-family: sans-serif; max-width: 500px; margin: 40px auto; padding: 20px; border: 1px solid #fecaca; background-color: #fef2f2; border-radius: 12px;'>";
    echo "<h2 style='color: #dc2626; margin-top: 0;'>Database Setup Error</h2>";
    echo "<p style='font-size: 13px;'>".htmlspecialchars($e->getMessage()).'</p>';
    echo '</div>';
}
