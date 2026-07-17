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
                ]);
            }
        }
    }
}
