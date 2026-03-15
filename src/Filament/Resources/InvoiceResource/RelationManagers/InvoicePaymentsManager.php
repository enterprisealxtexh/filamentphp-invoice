<?php

namespace Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

class InvoicePaymentsManager extends RelationManager
{
    protected static string $relationship = 'invoiceMetas';

    protected static ?string $title = 'Payments';

    public function table(Table $table): Table
    {
        $currency = app(InvoiceSettings::class)->default_currency ?? 'KES';

        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('key', 'payments'))
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label(trans('filament-invoices::messages.invoices.columns.amount'))
                    ->money($currency),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-invoices::messages.invoices.columns.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
