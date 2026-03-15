<?php

namespace Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\ViewAction::make(),
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\ForceDeleteAction::make(),
            \Filament\Actions\RestoreAction::make(),
        ];
    }
}
