<?php

namespace Alxtexh\FilamentInvoices\Services\Templates;

class ProfessionalTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'professional';
    }

    public function getLabel(): string
    {
        return 'Professional';
    }

    public function getDescription(): string
    {
        return 'A corporate-style layout ideal for business and enterprise invoices.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.professional';
    }
}
