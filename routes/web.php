<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use App\Http\Controllers\InvoicePdfController;
use App\Livewire\Admin\Cases\Create;
use App\Livewire\Admin\Cases\Edit;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Client\Appointments;
use App\Livewire\Client\Cases\Index;
use App\Livewire\Client\Cases\Show;
use App\Livewire\Client\Dashboard as ClientDashboard;
use App\Livewire\Installer;

Route::get('dashboard', function () {
    $user = auth()->user();
    try {
        if ($user && $user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }
    } catch (Throwable $e) {
        // Safety fallback if roles table isn't migrated/seeded yet
        if ($user && str_contains(strtolower($user->email), 'client')) {
            return redirect()->route('client.dashboard');
        }
    }

    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Client Portal Group
Route::middleware(['auth', 'verified', 'role:client'])->group(function () {
    Route::get('client/dashboard', ClientDashboard::class)->name('client.dashboard');
    Route::get('client/cases', Index::class)->name('client.cases.index');
    Route::get('client/cases/{matter}', Show::class)->name('client.cases.show');
    Route::get('client/appointments', Appointments::class)->name('client.appointments.index');
    Route::get('client/invoices', App\Livewire\Client\Invoices\Index::class)->name('client.invoices.index');
    Route::get('client/invoices/{invoice}', App\Livewire\Client\Invoices\Show::class)->name('client.invoices.show');
});

// Admin & Staff Group
Route::middleware(['auth', 'verified', 'role:admin|staff'])->group(function () {
    Route::get('admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

    // Admin Cases
    Route::get('admin/cases', App\Livewire\Admin\Cases\Index::class)->name('admin.cases.index');
    Route::get('admin/cases/create', Create::class)->name('admin.cases.create');
    Route::get('admin/cases/{matter}', App\Livewire\Admin\Cases\Show::class)->name('admin.cases.show');
    Route::get('admin/cases/{matter}/edit', Edit::class)->name('admin.cases.edit');

    // Admin Invoices
    Route::get('admin/invoices', App\Livewire\Admin\Invoices\Index::class)->name('admin.invoices.index');
    Route::get('admin/invoices/create', App\Livewire\Admin\Invoices\Create::class)->name('admin.invoices.create');
    Route::get('admin/invoices/{invoice}', App\Livewire\Admin\Invoices\Show::class)->name('admin.invoices.show');

    // General CRM & Dockets
    Route::get('admin/clients', App\Livewire\Admin\Clients\Index::class)->name('admin.clients.index');
    Route::get('admin/appointments', App\Livewire\Admin\Appointments\Index::class)->name('admin.appointments.index');
    Route::get('admin/documents', App\Livewire\Admin\Documents\Index::class)->name('admin.documents.index');
});

// Admin Only Settings & Staff Management Group
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('admin/staff', App\Livewire\Admin\Staff\Index::class)->name('admin.staff.index');
    Route::get('admin/logs', App\Livewire\Admin\Logs\Index::class)->name('admin.logs.index');
    Route::get('admin/settings', App\Livewire\Admin\Settings\Index::class)->name('admin.settings.index');
    Route::get('admin/roles', App\Livewire\Admin\Roles\Index::class)->name('admin.roles.index');
});

// Invoices PDF Download Route
Route::get('invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])
    ->middleware(['auth', 'verified'])
    ->name('invoices.pdf');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('terms', 'pages.terms')->name('terms');
Route::view('accessibility', 'pages.accessibility')->name('accessibility');

Route::get('install', Installer::class)->name('install.welcome');

Route::get('admin/login', function () {
    return redirect()->route('login');
})->name('admin.login');

require __DIR__.'/auth.php';
