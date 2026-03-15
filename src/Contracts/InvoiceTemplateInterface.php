<?php

namespace Alxtexh\FilamentInvoices\Contracts;

use Illuminate\Contracts\View\View;
use Alxtexh\FilamentInvoices\Models\Invoice;

interface InvoiceTemplateInterface
{
    public function getName(): string;

    public function getLabel(): string;

    public function getDescription(): string;

    public function getViewPath(): string;

    public function getThumbnail(): ?string;

    public function render(Invoice $invoice, array $options = []): View;
}
