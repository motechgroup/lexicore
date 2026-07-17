<?php

namespace App\Livewire\Admin\Settings;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

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

    // Livewire file uploads
    public $logoFile;

    public $faviconFile;

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

    // SMTP Mail settings properties
    public $mailHost;

    public $mailPort;

    public $mailUsername;

    public $mailPassword;

    public $mailEncryption;

    public $mailFromAddress;

    public $mailFromName;

    // Currency settings properties
    public $siteCurrency;

    public $siteCurrencySymbol;

    // Payment Gateways settings properties
    public $stripeEnabled = false;

    public $stripePublishableKey;

    public $stripeSecretKey;

    public $paypalEnabled = false;

    public $paypalClientId;

    public $paypalSecret;

    public $paypalMode = 'sandbox';

    protected $rules = [
        'firmName' => 'required|string|max:100',
        'taxRate' => 'required|numeric|min:0|max:100',
        'paymentTerms' => 'nullable|string',
        'siteTheme' => 'required|string|in:dark,light,system',
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

        // SMTP Validation
        'mailHost' => 'nullable|string|max:255',
        'mailPort' => 'nullable|integer|min:1|max:65535',
        'mailUsername' => 'nullable|string|max:255',
        'mailPassword' => 'nullable|string|max:255',
        'mailEncryption' => 'nullable|string|max:20',
        'mailFromAddress' => 'nullable|email|max:255',
        'mailFromName' => 'nullable|string|max:255',

        // Currency Validation
        'siteCurrency' => 'required|string|max:10',
        'siteCurrencySymbol' => 'required|string|max:10',

        // Gateways Validation
        'stripeEnabled' => 'boolean',
        'stripePublishableKey' => 'nullable|string|max:255',
        'stripeSecretKey' => 'nullable|string|max:255',
        'paypalEnabled' => 'boolean',
        'paypalClientId' => 'nullable|string|max:255',
        'paypalSecret' => 'nullable|string|max:255',
        'paypalMode' => 'required|string|in:sandbox,live',
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

        // Mount SMTP defaults
        $this->mailHost = $settings['mail_host'] ?? 'sandbox.smtp.mailtrap.io';
        $this->mailPort = $settings['mail_port'] ?? 2525;
        $this->mailUsername = $settings['mail_username'] ?? '';
        $this->mailPassword = $settings['mail_password'] ?? '';
        $this->mailEncryption = $settings['mail_encryption'] ?? 'tls';
        $this->mailFromAddress = $settings['mail_from_address'] ?? 'noreply@lexicore.test';
        $this->mailFromName = $settings['mail_from_name'] ?? 'LexCore Law';

        // Mount Currency defaults
        $this->siteCurrency = $settings['site_currency'] ?? 'USD';
        $this->siteCurrencySymbol = $settings['site_currency_symbol'] ?? '$';

        // Mount Gateway defaults
        $this->stripeEnabled = (bool) ($settings['stripe_enabled'] ?? false);
        $this->stripePublishableKey = $settings['stripe_publishable_key'] ?? '';
        $this->stripeSecretKey = $settings['stripe_secret_key'] ?? '';

        $this->paypalEnabled = (bool) ($settings['paypal_enabled'] ?? false);
        $this->paypalClientId = $settings['paypal_client_id'] ?? '';
        $this->paypalSecret = $settings['paypal_secret'] ?? '';
        $this->paypalMode = $settings['paypal_mode'] ?? 'sandbox';
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

        $logoPath = $this->logoUrl;
        if ($this->logoFile) {
            $this->validate([
                'logoFile' => 'image|max:2048',
            ]);
            $ext = $this->logoFile->getClientOriginalExtension();
            $logoName = 'logo.'.$ext;

            if (! file_exists(public_path('branding'))) {
                mkdir(public_path('branding'), 0755, true);
            }

            $this->logoFile->move(public_path('branding'), $logoName);
            $logoPath = '/branding/'.$logoName;
            $this->logoUrl = $logoPath;
        }

        $faviconPath = $this->faviconUrl;
        if ($this->faviconFile) {
            $this->validate([
                'faviconFile' => 'mimes:ico,png,jpg,jpeg|max:1024',
            ]);
            $ext = $this->faviconFile->getClientOriginalExtension();
            $faviconName = 'favicon.'.$ext;

            if (! file_exists(public_path('branding'))) {
                mkdir(public_path('branding'), 0755, true);
            }

            $this->faviconFile->move(public_path('branding'), $faviconName);
            $faviconPath = '/branding/'.$faviconName;
            $this->faviconUrl = $faviconPath;
        }

        $settings = [
            'firm_name' => $this->firmName,
            'tax_rate' => $this->taxRate,
            'payment_terms' => $this->paymentTerms,
            'site_theme' => $this->siteTheme,
            'logo_url' => $logoPath,
            'favicon_url' => $faviconPath,
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

            // Persist SMTP settings
            'mail_host' => $this->mailHost,
            'mail_port' => $this->mailPort,
            'mail_username' => $this->mailUsername,
            'mail_password' => $this->mailPassword,
            'mail_encryption' => $this->mailEncryption,
            'mail_from_address' => $this->mailFromAddress,
            'mail_from_name' => $this->mailFromName,

            // Persist Currency settings
            'site_currency' => $this->siteCurrency,
            'site_currency_symbol' => $this->siteCurrencySymbol,

            // Persist Gateways settings
            'stripe_enabled' => $this->stripeEnabled,
            'stripe_publishable_key' => $this->stripePublishableKey,
            'stripe_secret_key' => $this->stripeSecretKey,
            'paypal_enabled' => $this->paypalEnabled,
            'paypal_client_id' => $this->paypalClientId,
            'paypal_secret' => $this->paypalSecret,
            'paypal_mode' => $this->paypalMode,
        ];

        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));

        $this->logoFile = null;
        $this->faviconFile = null;

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
