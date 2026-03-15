<?php

namespace Alxtexh\FilamentInvoices;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource;
use Alxtexh\FilamentInvoices\Pages\InvoiceSettingsPage;

class FilamentInvoicesPlugin implements Plugin
{
    protected bool $useSettingsPage = true;

    public function getId(): string
    {
        return 'filament-invoices';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function useSettingsPage(bool $condition = true): static
    {
        $this->useSettingsPage = $condition;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            InvoiceResource::class,
        ]);

        if ($this->useSettingsPage) {
            $panel->pages([
                InvoiceSettingsPage::class,
            ]);
        }

        $panel->widgets([
            \Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets\InvoiceStatsWidget::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
