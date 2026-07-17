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

    // Notification Toggles settings properties
    public $notifyCaseUpdateEmail = true;

    public $notifyCaseUpdateSms = false;

    public $notifyAppointmentBookingEmail = true;

    public $notifyAppointmentBookingSms = false;

    public $notifyInvoiceGeneratedEmail = true;

    public $notifyInvoiceGeneratedSms = false;

    // SMS Gateway settings properties
    public $smsGatewayEnabled = false;

    public $twilioSid;

    public $twilioAuthToken;

    public $twilioFromNumber;

    // SMS Templates settings properties
    public $smsTemplateAppointment;

    public $smsTemplateInvoice;

    public $smsTemplateCase;

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

        // Notifications & SMS Validation
        'notifyCaseUpdateEmail' => 'boolean',
        'notifyCaseUpdateSms' => 'boolean',
        'notifyAppointmentBookingEmail' => 'boolean',
        'notifyAppointmentBookingSms' => 'boolean',
        'notifyInvoiceGeneratedEmail' => 'boolean',
        'notifyInvoiceGeneratedSms' => 'boolean',
        'smsGatewayEnabled' => 'boolean',
        'twilioSid' => 'nullable|string|max:255',
        'twilioAuthToken' => 'nullable|string|max:255',
        'twilioFromNumber' => 'nullable|string|max:50',
        'smsTemplateAppointment' => 'required|string|max:500',
        'smsTemplateInvoice' => 'required|string|max:500',
        'smsTemplateCase' => 'required|string|max:500',
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
        $this->privacyPolicy = $settings['privacy_policy'] ?? "# Privacy Policy\n*Last updated: July 17, 2026*\n\nLexCore Law Firm (\"we\", \"us\", or \"our\") operates the LexCore Client Portal. We are committed to protecting the privacy, confidentiality, and security of the personal data of our clients, staff, and website visitors.\n\n## 1. Information We Collect\nWe collect information that you provide directly to us when using our services:\n- **Client Profile Information**: Name, email, phone number, address, billing details, and identification credentials.\n- **Matter Details**: Sensitive case files, documents, and communications relevant to the legal services we perform.\n- **Consultation Bookings**: Appointment scheduling times, dates, case notes, and assignment requests.\n\n## 2. Attorney-Client Privilege & Confidentiality\nAll legal files, notes, and case materials uploaded to the LexCore Portal are protected by strict attorney-client privilege guidelines and professional rules of conduct. We do not disclose client case files to any third party except as authorized by the client or required by law.\n\n## 3. Data Protection & Security\nWe use industry-standard encryption protocols (including SSL/TLS connections and secure storage) to guard against unauthorized access, alteration, disclosure, or destruction of your personal data.\n\n## 4. Cookies & Tracking\nWe use essential cookies to maintain your login session and store theme preferences. You may disable cookies in your browser settings, but some features of the Client Portal may become unavailable.";
        $this->termsConditions = $settings['terms_conditions'] ?? "# Terms & Conditions\n*Last updated: July 17, 2026*\n\nWelcome to LexCore Law Firm. By accessing the LexCore Portal, you agree to be bound by the following Terms & Conditions.\n\n## 1. Legal Representation & Scope\nUse of this portal or booking a consultation does not establish an attorney-client relationship. A formal relationship is only established once a written retainer agreement is signed by both an authorized attorney of LexCore and the client.\n\n## 2. Retainer Billings & Payments\n- **Invoices**: Client billing statement totals are calculated based on hourly attorney rates or flat-fee arrangements as specified in your retainer agreement.\n- **Late Payments**: Outstanding balances must be paid within the term threshold (standard net-30).\n- **Payment Processing**: Online card payments and express checkouts are processed securely through Stripe or PayPal gateways.\n\n## 3. Portal Access & Use\nClients and staff must maintain secure passwords and are solely responsible for all activities conducted under their accounts. LexCore reserves the right to suspend portal access at any time for security violations or unpaid retainers.\n\n## 4. Uploaded Documentation\nYou represent and warrant that you own or have the necessary rights to all files and case documents uploaded to the LexCore Portal. Uploading malicious software, viruses, or illegal material is strictly prohibited.";
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

        // Mount Notification defaults
        $this->notifyCaseUpdateEmail = (bool) ($settings['notify_case_update_email'] ?? true);
        $this->notifyCaseUpdateSms = (bool) ($settings['notify_case_update_sms'] ?? false);
        $this->notifyAppointmentBookingEmail = (bool) ($settings['notify_appointment_booking_email'] ?? true);
        $this->notifyAppointmentBookingSms = (bool) ($settings['notify_appointment_booking_sms'] ?? false);
        $this->notifyInvoiceGeneratedEmail = (bool) ($settings['notify_invoice_generated_email'] ?? true);
        $this->notifyInvoiceGeneratedSms = (bool) ($settings['notify_invoice_generated_sms'] ?? false);

        // Mount SMS Gateway defaults
        $this->smsGatewayEnabled = (bool) ($settings['sms_gateway_enabled'] ?? false);
        $this->twilioSid = $settings['twilio_sid'] ?? '';
        $this->twilioAuthToken = $settings['twilio_auth_token'] ?? '';
        $this->twilioFromNumber = $settings['twilio_from_number'] ?? '';

        // Mount SMS Templates defaults
        $this->smsTemplateAppointment = $settings['sms_template_appointment'] ?? 'Hi {client_name}, your consultation at LexCore is scheduled for {appointment_date}.';
        $this->smsTemplateInvoice = $settings['sms_template_invoice'] ?? 'Dear {client_name}, a new invoice {invoice_number} has been generated. Total due: {invoice_total}.';
        $this->smsTemplateCase = $settings['sms_template_case'] ?? 'Hello, your case file {case_number} has been updated to: {case_status}.';
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

            // Persist Notification Preferences settings
            'notify_case_update_email' => $this->notifyCaseUpdateEmail,
            'notify_case_update_sms' => $this->notifyCaseUpdateSms,
            'notify_appointment_booking_email' => $this->notifyAppointmentBookingEmail,
            'notify_appointment_booking_sms' => $this->notifyAppointmentBookingSms,
            'notify_invoice_generated_email' => $this->notifyInvoiceGeneratedEmail,
            'notify_invoice_generated_sms' => $this->notifyInvoiceGeneratedSms,

            // Persist SMS Gateway settings
            'sms_gateway_enabled' => $this->smsGatewayEnabled,
            'twilio_sid' => $this->twilioSid,
            'twilio_auth_token' => $this->twilioAuthToken,
            'twilio_from_number' => $this->twilioFromNumber,

            // Persist SMS Templates settings
            'sms_template_appointment' => $this->smsTemplateAppointment,
            'sms_template_invoice' => $this->smsTemplateInvoice,
            'sms_template_case' => $this->smsTemplateCase,
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
