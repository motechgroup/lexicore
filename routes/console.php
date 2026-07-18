<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('lexcore:create-admin {email} {--name=Administrator} {--password=password}', function ($email) {
    $name = $this->option('name');
    $password = $this->option('password');

    $this->info("Configuring administrative credentials for: {$email}");

    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]
    );

    if (! $user->wasRecentlyCreated) {
        $user->update([
            'name' => $name,
            'password' => Hash::make($password),
        ]);
    }

    $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $user->assignRole($adminRole);

    $this->info("Success: Admin user '{$user->name}' ({$email}) has been configured and assigned the 'admin' role.");
})->purpose('Create or upgrade a user to administrative level on live environments');
