<?php

namespace Alxtexh\FilamentInvoices;

use Illuminate\Support\ServiceProvider;
use Alxtexh\FilamentInvoices\Console\FilamentInvoicesInstall;
use Alxtexh\FilamentInvoices\Services\InvoicesServices;
use Alxtexh\FilamentInvoices\Services\Templates\ClassicTemplate;
use Alxtexh\FilamentInvoices\Services\Templates\CreativeTemplate;
use Alxtexh\FilamentInvoices\Services\Templates\MinimalTemplate;
use Alxtexh\FilamentInvoices\Services\Templates\ModernTemplate;
use Alxtexh\FilamentInvoices\Services\Templates\ProfessionalTemplate;
use Alxtexh\FilamentInvoices\Services\Templates\TemplateFactory;

class FilamentInvoicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-invoices.php', 'filament-invoices');

        $this->app->singleton('filament-invoices', function () {
            return new InvoicesServices;
        });
    }

    public function boot(): void
    {
        // Register templates
        TemplateFactory::register('classic', ClassicTemplate::class);
        TemplateFactory::register('modern', ModernTemplate::class);
        TemplateFactory::register('minimal', MinimalTemplate::class);
        TemplateFactory::register('professional', ProfessionalTemplate::class);
        TemplateFactory::register('creative', CreativeTemplate::class);

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-invoices');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-invoices');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            // Register commands
            $this->commands([
                FilamentInvoicesInstall::class,
            ]);

            // Publish config
            $this->publishes([
                __DIR__ . '/../config/filament-invoices.php' => config_path('filament-invoices.php'),
            ], 'filament-invoices-config');

            // Publish views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-invoices'),
            ], 'filament-invoices-views');

            // Publish translations
            $this->publishes([
                __DIR__ . '/../resources/lang' => $this->app->langPath('vendor/filament-invoices'),
            ], 'filament-invoices-lang');

            // Publish migrations
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'filament-invoices-migrations');

            // Publish settings migration
            $this->publishes([
                __DIR__ . '/../database/settings' => database_path('settings'),
            ], 'filament-invoices-settings');
        }
    }
}
