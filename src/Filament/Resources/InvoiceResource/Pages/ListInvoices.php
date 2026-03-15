<?php

namespace Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource;
use Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets\InvoiceStatsWidget;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InvoiceStatsWidget::class,
        ];
    }
}
