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
                ]);
            }
        }
    }
}
