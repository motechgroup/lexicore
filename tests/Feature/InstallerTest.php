<?php

namespace Tests\Feature;

use App\Livewire\Installer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InstallerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['system.installer_completed' => false]);
    }

    public function test_installer_redirects_uninstalled_users(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/install');
    }

    public function test_installer_does_not_redirect_installed_users(): void
    {
        config(['system.installer_completed' => true]);

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_installer_renders_welcome_step(): void
    {
        config(['system.installer_completed' => false]);

        Livewire::test(Installer::class)
            ->assertSet('step', 1)
            ->assertSee('License Verification');
    }

    public function test_installer_licensing_requires_valid_details(): void
    {
        config(['system.installer_completed' => false]);

        Livewire::test(Installer::class)
            ->set('envatoUsername', '')
            ->set('purchaseCode', '')
            ->call('verifyLicense')
            ->assertHasErrors(['envatoUsername', 'purchaseCode']);

        Livewire::test(Installer::class)
            ->set('envatoUsername', 'buyer')
            ->set('purchaseCode', 'invalid-code')
            ->call('verifyLicense')
            ->assertHasErrors(['purchaseCode']);

        Livewire::test(Installer::class)
            ->set('envatoUsername', 'buyer')
            ->set('purchaseCode', '12345678-1234-1234-1234-123456789012')
            ->call('verifyLicense')
            ->assertHasNoErrors()
            ->assertSet('step', 2);
    }
}
