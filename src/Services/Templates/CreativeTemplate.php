<?php

namespace Alxtexh\FilamentInvoices\Services\Templates;

class CreativeTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'creative';
    }

    public function getLabel(): string
    {
        return 'Creative';
    }

    public function getDescription(): string
    {
        return 'A bold and colorful design for creative businesses.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.creative';
    }
}
