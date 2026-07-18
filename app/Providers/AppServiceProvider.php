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
        $settingsPath = storage_path('app/private/settings.json');
        if (! file_exists($settingsPath)) {
            $settingsPath = storage_path('app/settings.json');
        }
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

                    // SEO & Google Analytics config bindings
                    'system.seo_title' => $settings['seo_title'] ?? '',
                    'system.seo_description' => $settings['seo_description'] ?? '',
                    'system.seo_keywords' => $settings['seo_keywords'] ?? '',
                    'system.google_analytics_id' => $settings['google_analytics_id'] ?? '',

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

                    // Elite Leadership configurations
                    'system.leader_headline' => $settings['leader_headline'] ?? 'Elite Leadership',
                    'system.leader_subtitle' => $settings['leader_subtitle'] ?? 'Our attorneys are recognized leaders in their fields, frequently cited in national media and academic journals.',
                    'system.leader_1_name' => $settings['leader_1_name'] ?? 'Julian Thorne',
                    'system.leader_1_title' => $settings['leader_1_title'] ?? 'Managing Partner',
                    'system.leader_1_description' => $settings['leader_1_description'] ?? 'Specializing in Cross-Border M&A and Strategic Advisory.',
                    'system.leader_1_image' => $settings['leader_1_image'] ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuDUSUFnRGzUKW9rQGna9F0Rqx7XiOEeTKZ_ZjFNqpM20c0HpWZ5g3kVDQorJAFkVWElHWzZyyfh9prkVn1SSg9UaRggUQXB--bK3TqGvaMzsByacPZHnyp_W6FqCoCqmoa3ZxCz9rxKq2-LUqvlr56omdaMQaTMIFOBItnzAWDPuEWide7UVsapEIjSbiboOrx8iyOGn23wwr-YYZIbsrtOkpXtgvyLUU7J5xnBafW0eFLAFFGmkbGzxA',
                    'system.leader_2_name' => $settings['leader_2_name'] ?? 'Sarah Kensington',
                    'system.leader_2_title' => $settings['leader_2_title'] ?? 'Senior Partner, IP',
                    'system.leader_2_description' => $settings['leader_2_description'] ?? 'Recognized as one of the top 50 IP litigators in the country.',
                    'system.leader_2_image' => $settings['leader_2_image'] ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuD8-Hj7QxqJVPkNOzaDbA4X5Wf1-KE7g_R-Rf5q70p2ntTcSo2OPIAqGjuELzZETa5gUzP-ANYtBgyvIfZVQBHgdAzNWOlAHTbz60xse078jAUsXhA-cw2XE3ZcL70H9n0yb9nahYlVr2aILfR5A_mRhrooH4--I2NO_umOcRs70zvxgtoCdMjXsVniz33AJjYVzrPDduA1nbFwCIkxyL6lQ2hfXJHj9lrs3fp1-8Y6xcy_1Ot4SBWDwQ',
                    'system.leader_3_name' => $settings['leader_3_name'] ?? 'Marcus Vane',
                    'system.leader_3_title' => $settings['leader_3_title'] ?? 'Litigation Partner',
                    'system.leader_3_description' => $settings['leader_3_description'] ?? 'Expert in high-stakes white-collar defense and civil litigation.',
                    'system.leader_3_image' => $settings['leader_3_image'] ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfR2Eho-JK7dkZZ0dl-EpoO3ZRa1r1anOPIV9WwxTZSEPjSLHwPuTXRu8P1Bp1hHxRZZ3WLdW4D7_BiM7aUurMjOnN7WcO8CuefKjQJM0PaSQq7jclmZWLBFvI2QPLnS7GpDNkeh5v-1vUn1lNw1wM1Hqt1QgsG15yXVyo1005jfGb0iFz9_QJKMX15J3lCUN0eEXOzlYQg2NUv2M849uLW--1TlIpwnGChp5BT7PM1KT27Q00xLlMYA',
                    'system.leader_4_name' => $settings['leader_4_name'] ?? 'Elena Rodriguez',
                    'system.leader_4_title' => $settings['leader_4_title'] ?? 'Private Wealth Lead',
                    'system.leader_4_description' => $settings['leader_4_description'] ?? 'Bespoke estate planning for ultra-high-net-worth families.',
                    'system.leader_4_image' => $settings['leader_4_image'] ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1sZwRy7th2uNe38jq37PbLA8AiXzQERTF_96UbTxjJH-y-nNX4IrAbODxzQ9t93Q5yEF4VmUy8R6GKFOtKwMEtdr7t3kdk_0tGFKkcujJKXO-nPxcGp6WCI1hC8YAqkg3pZ-3miR117CpkoR7gqGnnV3ces1Ggu3uiLgreK2c9vAEX5YYmyjNxNuapv57bzedyVRyKNG5tb24tD_0PrNv8lLNe0ykfb6vRV7UTY4Sa88gysZrM-e33Q',

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
