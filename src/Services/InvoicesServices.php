<?php

namespace Alxtexh\FilamentInvoices\Services;

use Illuminate\Support\Collection;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceFor;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceFrom;

class InvoicesServices
{
    public array $from = [];

    public array $for = [];

    public array $statuses = [];

    public array $types = [];

    public function registerFrom(array|InvoiceFrom $from): void
    {
        if (is_array($from)) {
            foreach ($from as $item) {
                $this->registerFrom($item);
            }
        } else {
            $this->from[] = $from;
        }
    }

    public function registerFor(array|InvoiceFor $for): void
    {
        if (is_array($for)) {
            foreach ($for as $item) {
                $this->registerFor($item);
            }
        } else {
            $this->for[] = $for;
        }
    }

    public function getFrom(): Collection
    {
        return collect($this->from);
    }

    public function getFor(): Collection
    {
        return collect($this->for);
    }

    public function create(): CreateInvoice
    {
        return new CreateInvoice;
    }

    public function getStatuses(): array
    {
        return [
            'draft' => 'Draft',
            'sent' => 'Sent',
            'paid' => 'Paid',
            'overdue' => 'Overdue',
            'cancelled' => 'Cancelled',
        ];
    }

    public function getStatusColors(): array
    {
        return [
            'draft' => 'gray',
            'sent' => 'info',
            'paid' => 'success',
            'overdue' => 'danger',
            'cancelled' => 'warning',
        ];
    }

    public function getStatusIcons(): array
    {
        return [
            'draft' => 'heroicon-o-document',
            'sent' => 'heroicon-o-paper-airplane',
            'paid' => 'heroicon-o-check-circle',
            'overdue' => 'heroicon-o-clock',
            'cancelled' => 'heroicon-o-x-circle',
        ];
    }

    public function getTypes(): array
    {
        return [
            'push' => 'Push Invoice',
            'sale' => 'Sale Invoice',
            'estimate' => 'Estimate',
            'receipt' => 'Receipt',
        ];
    }
}
