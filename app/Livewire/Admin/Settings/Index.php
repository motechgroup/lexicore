<?php

namespace App\Livewire\Admin\Settings;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public $firmName;

    public $taxRate;

    public $paymentTerms;

    // Extended branding, theme, policy settings
    public $siteTheme = 'dark';

    public $logoUrl;

    public $faviconUrl;

    public $privacyPolicy;

    public $termsConditions;

    public $footerText;

    protected $rules = [
        'firmName' => 'required|string|max:100',
        'taxRate' => 'required|numeric|min:0|max:100',
        'paymentTerms' => 'nullable|string',
        'siteTheme' => 'required|string|in:dark,light,system',
        'logoUrl' => 'nullable|string|max:255',
        'faviconUrl' => 'nullable|string|max:255',
        'privacyPolicy' => 'nullable|string',
        'termsConditions' => 'nullable|string',
        'footerText' => 'nullable|string|max:255',
    ];

    /**
     * Mount the component.
     */
    public function mount()
    {
        $settings = $this->loadSettings();
        $this->firmName = $settings['firm_name'] ?? 'LexCore Law Firm';
        $this->taxRate = $settings['tax_rate'] ?? 8.5;
        $this->paymentTerms = $settings['payment_terms'] ?? 'Please reference invoice number on wire transfer. Standard terms are net-30 days.';

        $this->siteTheme = $settings['site_theme'] ?? 'dark';
        $this->logoUrl = $settings['logo_url'] ?? '';
        $this->faviconUrl = $settings['favicon_url'] ?? '';
        $this->privacyPolicy = $settings['privacy_policy'] ?? "## Privacy Policy\nYour privacy is important to us. It is our policy to respect your privacy regarding any information we may collect from you across our website.";
        $this->termsConditions = $settings['terms_conditions'] ?? "## Terms & Conditions\nBy accessing our website, you agree to be bound by these terms of service, all applicable laws and regulations.";
        $this->footerText = $settings['footer_text'] ?? '© '.date('Y').' LexCore Law Firm. All rights reserved. Registered Bar Association Council.';
    }

    /**
     * Load settings from storage.
     */
    protected function loadSettings()
    {
        if (Storage::exists('settings.json')) {
            return json_decode(Storage::get('settings.json'), true) ?: [];
        }

        return [];
    }

    /**
     * Save system configurations.
     */
    public function save()
    {
        $this->validate();

        $settings = [
            'firm_name' => $this->firmName,
            'tax_rate' => $this->taxRate,
            'payment_terms' => $this->paymentTerms,
            'site_theme' => $this->siteTheme,
            'logo_url' => $this->logoUrl,
            'favicon_url' => $this->faviconUrl,
            'privacy_policy' => $this->privacyPolicy,
            'terms_conditions' => $this->termsConditions,
            'footer_text' => $this->footerText,
        ];

        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));
        session()->flash('status', 'System configuration saved successfully.');
    }

    /**
     * Simulate database backup trigger.
     */
    public function triggerBackup()
    {
        session()->flash('status', 'System database and file archive backup completed successfully.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        return view('livewire.admin.settings.index')
            ->layout('layouts.admin');
    }
}
