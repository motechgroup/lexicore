<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent lazy loading, silently discarding attributes, and accessing missing attributes in non-production.
        Model::shouldBeStrict(! $this->app->isProduction());

        // Ensure database string length compatibility for shared hosting environments.
        Schema::defaultStringLength(191);

        // Bootstrap dynamic configuration parameters from local settings.json
        $settingsPath = storage_path('app/settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            if (is_array($settings)) {
                config([
                    'system.firm_name' => $settings['firm_name'] ?? 'LexCore',
                    'system.tax_rate' => $settings['tax_rate'] ?? 8.5,
                    'system.payment_terms' => $settings['payment_terms'] ?? '',
                    'system.site_theme' => $settings['site_theme'] ?? 'dark',
                    'system.logo_url' => $settings['logo_url'] ?? '',
                    'system.favicon_url' => $settings['favicon_url'] ?? '',
                    'system.privacy_policy' => $settings['privacy_policy'] ?? '',
                    'system.terms_conditions' => $settings['terms_conditions'] ?? '',
                    'system.accessibility_policy' => $settings['accessibility_policy'] ?? '',
                    'system.footer_text' => $settings['footer_text'] ?? '',

                    // Dynamic Homepage CMS config bindings
                    'system.hero_title' => $settings['hero_title'] ?? 'Sophisticated counsel for complex legal landscapes.',
                    'system.hero_subtitle' => $settings['hero_subtitle'] ?? 'ESTABLISHED 1984',
                    'system.hero_description' => $settings['hero_description'] ?? 'LexCore Law Firm provides elite representation across corporate, intellectual property, and high-stakes litigation matters. We combine heritage with modern agility to protect your legacy.',
                    'system.stat_recovered' => $settings['stat_recovered'] ?? '$2.4B+',
                    'system.stat_years' => $settings['stat_years'] ?? '40+',
                    'system.stat_retention' => $settings['stat_retention'] ?? '98%',
                    'system.stat_partners' => $settings['stat_partners'] ?? '150+',
                    'system.cta_title' => $settings['cta_title'] ?? 'Secure your future with proven expertise.',
                    'system.cta_description' => $settings['cta_description'] ?? 'Contact us today for a confidential consultation. Our partners are ready to discuss your matter with the gravity it deserves.',

                    // SMTP configurations
                    'mail.mailers.smtp.host' => $settings['mail_host'] ?? env('MAIL_HOST', 'sandbox.smtp.mailtrap.io'),
                    'mail.mailers.smtp.port' => $settings['mail_port'] ?? env('MAIL_PORT', 2525),
                    'mail.mailers.smtp.username' => $settings['mail_username'] ?? env('MAIL_USERNAME'),
                    'mail.mailers.smtp.password' => $settings['mail_password'] ?? env('MAIL_PASSWORD'),
                    'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls'),
                    'mail.from.address' => $settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', 'noreply@lexicore.test'),
                    'mail.from.name' => $settings['mail_from_name'] ?? env('MAIL_FROM_NAME', 'LexCore Law'),

                    // Currency configurations
                    'system.site_currency' => $settings['site_currency'] ?? 'USD',
                    'system.site_currency_symbol' => $settings['site_currency_symbol'] ?? '$',

                    // Services configurations
                    'services.stripe.key' => $settings['stripe_secret_key'] ?? env('STRIPE_SECRET'),
                    'services.stripe.pub' => $settings['stripe_publishable_key'] ?? env('STRIPE_KEY'),
                    'services.paypal.client_id' => $settings['paypal_client_id'] ?? env('PAYPAY_CLIENT_ID'),
                    'services.paypal.secret' => $settings['paypal_secret'] ?? env('PAYPAL_SECRET'),
                    'services.paypal.mode' => $settings['paypal_mode'] ?? 'sandbox',

                    // Twilio SMS gateway configurations
                    'services.twilio.sid' => $settings['twilio_sid'] ?? env('TWILIO_SID'),
                    'services.twilio.token' => $settings['twilio_auth_token'] ?? env('TWILIO_AUTH_TOKEN'),
                    'services.twilio.from' => $settings['twilio_from_number'] ?? env('TWILIO_FROM'),

                    // Notification preferences
                    'system.notifications.case_update_email' => (bool) ($settings['notify_case_update_email'] ?? true),
                    'system.notifications.case_update_sms' => (bool) ($settings['notify_case_update_sms'] ?? false),
                    'system.notifications.appointment_booking_email' => (bool) ($settings['notify_appointment_booking_email'] ?? true),
                    'system.notifications.appointment_booking_sms' => (bool) ($settings['notify_appointment_booking_sms'] ?? false),
                    'system.notifications.invoice_generated_email' => (bool) ($settings['notify_invoice_generated_email'] ?? true),
                    'system.notifications.invoice_generated_sms' => (bool) ($settings['notify_invoice_generated_sms'] ?? false),

                    // SMS templates
                    'system.sms_templates.appointment' => $settings['sms_template_appointment'] ?? 'Hi {client_name}, your consultation at LexCore is scheduled for {appointment_date}.',
                    'system.sms_templates.invoice' => $settings['sms_template_invoice'] ?? 'Dear {client_name}, a new invoice {invoice_number} has been generated. Total due: {invoice_total}.',
                    'system.sms_templates.case' => $settings['sms_template_case'] ?? 'Hello, your case file {case_number} has been updated to: {case_status}.',
                ]);
            }
        }
    }
}
