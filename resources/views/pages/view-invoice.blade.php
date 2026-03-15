<div>
    <style>
        .invoice-container {
            font-family: system-ui, -apple-system, sans-serif;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
        }
        @media (max-width: 640px) {
            .invoice-header {
                flex-direction: column;
            }
        }
        .invoice-column {
            width: 100%;
        }
        .invoice-column-right {
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        .invoice-logo {
            width: 4rem;
            height: auto;
        }
        .invoice-section {
            display: flex;
            flex-direction: column;
        }
        .invoice-label {
            font-size: 0.875rem;
            color: #9ca3af;
            margin-top: 0.75rem;
        }
        .invoice-name {
            font-size: 1.125rem;
            font-weight: 700;
        }
        .invoice-text {
            font-size: 0.875rem;
        }
        .invoice-text-muted {
            font-size: 0.875rem;
            color: #9ca3af;
        }
        .invoice-bill-to {
            margin-top: 1.5rem;
        }
        .invoice-bill-to-inner {
            margin-top: 1rem;
        }
        .invoice-title-section {
            display: flex;
            justify-content: flex-end;
            font-weight: 700;
        }
        .invoice-title {
            font-size: 1.875rem;
            text-transform: uppercase;
        }
        .invoice-meta-section {
            display: flex;
            justify-content: flex-end;
            height: 100%;
        }
        .invoice-meta-inner {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .invoice-meta-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }
        .invoice-meta-label {
            color: #9ca3af;
        }
        .invoice-items-container {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin: 1rem 0;
            padding: 0 0.5rem;
        }
        .dark .invoice-items-container {
            border-color: #374151;
        }
        .invoice-items-header {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            font-weight: 700;
            border-bottom: 1px solid #e5e7eb;
            text-align: start;
        }
        .dark .invoice-items-header {
            border-color: #374151;
        }
        .invoice-items-header-cell {
            padding: 0.5rem;
            width: 100%;
        }
        .invoice-items-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .invoice-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .invoice-item:last-child {
            border-bottom: none;
        }
        .dark .invoice-item {
            border-color: rgba(255, 255, 255, 0.05);
        }
        .invoice-item-details {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .invoice-item-name {
            font-weight: 700;
            font-size: 1.125rem;
        }
        .invoice-item-description {
            color: #9ca3af;
        }
        .invoice-item-totals {
            width: 100%;
            padding: 0.5rem;
        }
        .invoice-item-totals-inner {
            display: flex;
            flex-direction: column;
            margin-top: 0.5rem;
        }
        .invoice-item-row {
            display: flex;
            justify-content: space-between;
        }
        .invoice-item-row-label {
            font-size: 0.875rem;
            color: #9ca3af;
            text-transform: uppercase;
            width: 100%;
        }
        .invoice-item-row-value {
            width: 100%;
        }
        .invoice-item-row-value-bold {
            width: 100%;
            font-weight: 700;
        }
        .invoice-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
        @media (max-width: 640px) {
            .invoice-footer {
                flex-direction: column;
                gap: 2rem;
            }
        }
        .invoice-footer-left {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 1rem;
            width: 100%;
        }
        .invoice-footer-right {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
            width: 100%;
        }
        .invoice-section-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        .invoice-signature {
            font-size: 0.875rem;
            color: #9ca3af;
        }
        .invoice-summary-row {
            display: flex;
            justify-content: space-between;
        }
        .invoice-summary-label {
            font-weight: 700;
        }
        .invoice-summary-paid {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
        }
        .dark .invoice-summary-paid {
            border-color: #374151;
        }
        .invoice-balance-due {
            display: flex;
            justify-content: space-between;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .invoice-notes-divider {
            border-bottom: 1px solid #e5e7eb;
            margin: 1rem 0;
        }
        .dark .invoice-notes-divider {
            border-color: #374151;
        }
        .invoice-currency {
            font-size: 0.875rem;
            font-weight: 400;
        }
    </style>

    <x-filament-panels::page>
        <x-filament::section>
            <div class="invoice-container">
                <div class="invoice-header">
                    <div class="invoice-column">
                        @php
                            $settings = app(\Alxtexh\FilamentInvoices\Settings\InvoiceSettings::class);
                            $record = $this->getRecord();
                            $currency = $record->currency ?? $settings->default_currency ?? 'KES';
                            $billedFrom = $record->from_type ? $record->from_type::find($record->from_id) : null;
                            $billedFor = $record->for_type ? $record->for_type::find($record->for_id) : null;
                        @endphp

                        @if($settings->company_logo)
                            <div>
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings->company_logo) }}" alt="{{ $settings->company_name }}" class="invoice-logo">
                            </div>
                        @endif

                        <div class="invoice-section">
                            <div class="invoice-label">
                                {{ trans('filament-invoices::messages.invoices.view.bill_from') }}:
                            </div>
                            <div class="invoice-name">
                                {{ $billedFrom?->name ?? $settings->company_name ?? '' }}
                            </div>
                            @if($billedFrom?->phone ?? $settings->company_phone)
                                <div class="invoice-text">
                                    {{ $billedFrom?->phone ?? $settings->company_phone }}
                                </div>
                            @endif
                            @if($billedFrom?->email ?? $settings->company_email)
                                <div class="invoice-text">
                                    {{ $billedFrom?->email ?? $settings->company_email }}
                                </div>
                            @endif
                            @if($billedFrom?->address ?? $settings->company_address)
                                <div class="invoice-text">
                                    {{ $billedFrom?->address ?? $settings->company_address }}
                                </div>
                            @endif
                        </div>

                        <div class="invoice-bill-to">
                            <div class="invoice-bill-to-inner">
                                <div class="invoice-label">
                                    {{ trans('filament-invoices::messages.invoices.view.bill_to') }}:
                                </div>
                                <div class="invoice-name">
                                    {{ $billedFor?->name ?? $record->name ?? '' }}
                                </div>
                                @if($billedFor?->email)
                                    <div class="invoice-text">
                                        {{ $billedFor->email }}
                                    </div>
                                @endif
                                @if($record->phone ?? $billedFor?->phone)
                                    <div class="invoice-text">
                                        {{ $record->phone ?? $billedFor?->phone }}
                                    </div>
                                @endif
                                @if($record->address ?? $billedFor?->address)
                                    <div class="invoice-text">
                                        {{ $record->address ?? $billedFor?->address }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="invoice-column-right">
                        <div class="invoice-title-section">
                            <div>
                                <div>
                                    <h1 class="invoice-title">{{ trans('filament-invoices::messages.invoices.view.invoice') }}</h1>
                                </div>
                                <div>
                                    #{{ $record->uuid }}
                                </div>
                            </div>
                        </div>
                        <div class="invoice-meta-section">
                            <div class="invoice-meta-inner">
                                <div>
                                    <div class="invoice-meta-row">
                                        <div class="invoice-meta-label">{{ trans('filament-invoices::messages.invoices.view.issue_date') }} : </div>
                                        <div>{{ $record->date?->toDateString() ?? $record->created_at->toDateString() }}</div>
                                    </div>
                                    <div class="invoice-meta-row">
                                        <div class="invoice-meta-label">{{ trans('filament-invoices::messages.invoices.view.due_date') }} : </div>
                                        <div>{{ $record->due_date?->toDateString() }}</div>
                                    </div>
                                    <div class="invoice-meta-row">
                                        <div class="invoice-meta-label">{{ trans('filament-invoices::messages.invoices.view.status') }} : </div>
                                        <div>{{ ucfirst($record->status) }}</div>
                                    </div>
                                    <div class="invoice-meta-row">
                                        <div class="invoice-meta-label">{{ trans('filament-invoices::messages.invoices.view.type') }} : </div>
                                        <div>{{ ucfirst(str_replace('_', ' ', $record->type ?? '')) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="invoice-items-container">
                        <div>
                            <div class="invoice-items-header">
                                <div class="invoice-items-header-cell">
                                    {{ trans('filament-invoices::messages.invoices.view.item') }}
                                </div>
                                <div class="invoice-items-header-cell">
                                    {{ trans('filament-invoices::messages.invoices.view.total') }}
                                </div>
                            </div>
                        </div>
                        <div class="invoice-items-list">
                            @foreach($record->invoicesItems as $item)
                                <div class="invoice-item">
                                    <div class="invoice-item-details">
                                        <div>
                                            <div class="invoice-item-name">
                                                {{ $item->item }}
                                            </div>
                                            @if($item->description)
                                                <div class="invoice-item-description">
                                                    {{ $item->description }}
                                                </div>
                                            @endif
                                            @if($item->options)
                                                <div class="invoice-item-description">
                                                    @foreach($item->options ?? [] as $label => $options)
                                                        <span>{{ str($label)->ucfirst() }}</span> : {{ $options }} <br>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="invoice-item-totals">
                                        <div class="invoice-item-totals-inner">
                                            <div class="invoice-item-row">
                                                <span class="invoice-item-row-label">{{ trans('filament-invoices::messages.invoices.view.price') }}:</span>
                                                <span class="invoice-item-row-value">
                                                    {{ number_format($item->price, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                                </span>
                                            </div>
                                            <div class="invoice-item-row">
                                                <span class="invoice-item-row-label">{{ trans('filament-invoices::messages.invoices.view.vat') }}:</span>
                                                <span class="invoice-item-row-value">
                                                    {{ number_format($item->vat ?? 0, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                                </span>
                                            </div>
                                            <div class="invoice-item-row">
                                                <span class="invoice-item-row-label">{{ trans('filament-invoices::messages.invoices.view.discount') }}:</span>
                                                <span class="invoice-item-row-value">
                                                    {{ number_format($item->discount, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                                </span>
                                            </div>
                                            <div class="invoice-item-row">
                                                <span class="invoice-item-row-label">{{ trans('filament-invoices::messages.invoices.view.qty') }}:</span>
                                                <span class="invoice-item-row-value">
                                                    {{ $item->qty }}
                                                </span>
                                            </div>
                                            <div class="invoice-item-row">
                                                <span class="invoice-item-row-label">{{ trans('filament-invoices::messages.invoices.view.total') }}:</span>
                                                <span class="invoice-item-row-value-bold">
                                                    {{ number_format($item->total, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="invoice-footer">
                        <div class="invoice-footer-left">
                            <div>
                                <div class="invoice-section-title">
                                    {{ trans('filament-invoices::messages.invoices.view.signature') }}
                                </div>
                                <div class="invoice-signature">
                                    <div>{{ $billedFrom?->name ?? $settings->company_name ?? '' }}</div>
                                    <div>{{ $billedFrom?->email ?? $settings->company_email ?? '' }}</div>
                                    <div>{{ $billedFrom?->phone ?? $settings->company_phone ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-footer-right">
                            <div class="invoice-summary-row">
                                <div class="invoice-summary-label">
                                    {{ trans('filament-invoices::messages.invoices.view.subtotal') }}
                                </div>
                                <div>
                                    {{ number_format(($record->total + $record->discount) - ($record->vat + $record->shipping), 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                </div>
                            </div>
                            <div class="invoice-summary-row">
                                <div class="invoice-summary-label">
                                    {{ trans('filament-invoices::messages.invoices.view.tax') }}
                                </div>
                                <div>
                                    {{ number_format($record->vat, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                </div>
                            </div>
                            <div class="invoice-summary-row">
                                <div class="invoice-summary-label">
                                    {{ trans('filament-invoices::messages.invoices.view.discount') }}
                                </div>
                                <div>
                                    {{ number_format($record->discount, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                </div>
                            </div>
                            <div class="invoice-summary-paid">
                                <div class="invoice-summary-label">
                                    {{ trans('filament-invoices::messages.invoices.view.paid') }}
                                </div>
                                <div>
                                    {{ number_format($record->paid, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                </div>
                            </div>
                            <div class="invoice-balance-due">
                                <div>
                                    {{ trans('filament-invoices::messages.invoices.view.balance_due') }}
                                </div>
                                <div>
                                    {{ number_format($record->total - $record->paid, 2) }}<small class="invoice-currency">{{ $currency }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($record->notes)
                        <div class="invoice-notes-divider"></div>
                        <div>
                            <div class="invoice-section-title">
                                {{ trans('filament-invoices::messages.invoices.view.notes') }}
                            </div>
                            <div class="invoice-text-muted">
                                {!! nl2br(e($record->notes)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </x-filament::section>

        @php
            $relationManagers = $this->getRelationManagers();
        @endphp

        @if (count($relationManagers))
            <div class="no-print" style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach ($relationManagers as $managerKey => $manager)
                    @php
                        $managerClass = $manager instanceof \Filament\Resources\RelationManagers\RelationManagerConfiguration
                            ? $manager->relationManager
                            : $manager;
                        $ownerRecord = $this->getRecord();
                    @endphp
                    @livewire($managerClass, ['ownerRecord' => $ownerRecord, 'pageClass' => get_class($this)], key($managerClass . '-' . $ownerRecord->getKey()))
                @endforeach
            </div>
        @endif
    </x-filament-panels::page>

    <style type="text/css" media="print">
        .fi-section-content-ctn {
            padding: 0 !important;
            border: none !important;
        }
        .fi-section {
            border: none !important;
            box-shadow: none !important;
        }
        .fi-section-content {
            border: none !important;
            box-shadow: none !important;
        }
        .fi-main {
            margin: 0 !important;
            padding: 0 !important;
            background-color: white !important;
            color: black !important;
        }
        .no-print { display: none !important; }
        .fi-header { display: none !important; }
        .fi-topbar { display: none !important; }
        .fi-sidebar { display: none !important; }
        .fi-sidebar-close-overlay { display: none !important; }
    </style>
</div>
