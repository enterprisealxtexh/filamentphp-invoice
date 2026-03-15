<?php

namespace Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Alxtexh\FilamentInvoices\Models\Invoice;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

class InvoiceStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $settings = app(InvoiceSettings::class);
        $currency = $settings->default_currency ?? 'KES';

        return [
            Stat::make(
                trans('filament-invoices::messages.invoices.widgets.total'),
                $currency . ' ' . number_format(Invoice::sum('total'), 2)
            )->icon('heroicon-o-banknotes'),
            Stat::make(
                trans('filament-invoices::messages.invoices.widgets.paid'),
                $currency . ' ' . number_format(Invoice::sum('paid'), 2)
            )->icon('heroicon-o-check-circle')->color('success'),
            Stat::make(
                trans('filament-invoices::messages.invoices.widgets.due'),
                $currency . ' ' . number_format(Invoice::sum('total') - Invoice::sum('paid'), 2)
            )->icon('heroicon-o-clock')->color('danger'),
            Stat::make(
                trans('filament-invoices::messages.invoices.widgets.overdue'),
                Invoice::where('due_date', '<', now())->where('status', '!=', 'paid')->count()
            )->icon('heroicon-o-exclamation-triangle')->color('warning'),
        ];
    }
}
