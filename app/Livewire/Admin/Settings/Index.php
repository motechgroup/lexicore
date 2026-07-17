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

    // Homepage CMS settings properties
    public $heroTitle;

    public $heroSubtitle;

    public $heroDescription;

    public $statRecovered;

    public $statYears;

    public $statRetention;

    public $statPartners;

    public $ctaTitle;

    public $ctaDescription;

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

        // CMS validation rules
        'heroTitle' => 'required|string|max:255',
        'heroSubtitle' => 'required|string|max:100',
        'heroDescription' => 'required|string',
        'statRecovered' => 'required|string|max:20',
        'statYears' => 'required|string|max:20',
        'statRetention' => 'required|string|max:20',
        'statPartners' => 'required|string|max:20',
        'ctaTitle' => 'required|string|max:255',
        'ctaDescription' => 'required|string',
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

        // Mount Homepage CMS defaults
        $this->heroTitle = $settings['hero_title'] ?? 'Sophisticated counsel for complex legal landscapes.';
        $this->heroSubtitle = $settings['hero_subtitle'] ?? 'ESTABLISHED 1984';
        $this->heroDescription = $settings['hero_description'] ?? 'LexCore Law Firm provides elite representation across corporate, intellectual property, and high-stakes litigation matters. We combine heritage with modern agility to protect your legacy.';
        $this->statRecovered = $settings['stat_recovered'] ?? '$2.4B+';
        $this->statYears = $settings['stat_years'] ?? '40+';
        $this->statRetention = $settings['stat_retention'] ?? '98%';
        $this->statPartners = $settings['stat_partners'] ?? '150+';
        $this->ctaTitle = $settings['cta_title'] ?? 'Secure your future with proven expertise.';
        $this->ctaDescription = $settings['cta_description'] ?? 'Contact us today for a confidential consultation. Our partners are ready to discuss your matter with the gravity it deserves.';
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

            // Persist Homepage CMS fields
            'hero_title' => $this->heroTitle,
            'hero_subtitle' => $this->heroSubtitle,
            'hero_description' => $this->heroDescription,
            'stat_recovered' => $this->statRecovered,
            'stat_years' => $this->statYears,
            'stat_retention' => $this->statRetention,
            'stat_partners' => $this->statPartners,
            'cta_title' => $this->ctaTitle,
            'cta_description' => $this->ctaDescription,
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
