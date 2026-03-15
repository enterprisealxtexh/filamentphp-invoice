<?php

namespace Alxtexh\FilamentInvoices\Services\Templates;

use Illuminate\Contracts\View\View;
use Alxtexh\FilamentInvoices\Contracts\InvoiceTemplateInterface;
use Alxtexh\FilamentInvoices\Models\Invoice;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

abstract class AbstractTemplate implements InvoiceTemplateInterface
{
    protected InvoiceSettings $settings;

    public function __construct()
    {
        $this->settings = app(InvoiceSettings::class);
    }

    public function getThumbnail(): ?string
    {
        return null;
    }

    public function render(Invoice $invoice, array $options = []): View
    {
        return view($this->getViewPath(), [
            'invoice' => $invoice,
            'settings' => $this->settings,
            'options' => $options,
            'template' => $this,
        ]);
    }

    protected function getCompanyLogoUrl(): ?string
    {
        if (empty($this->settings->company_logo)) {
            return null;
        }

        return url('storage/' . $this->settings->company_logo);
    }
}
