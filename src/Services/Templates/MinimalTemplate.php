<?php

namespace Alxtexh\FilamentInvoices\Services\Templates;

class MinimalTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'minimal';
    }

    public function getLabel(): string
    {
        return 'Minimal';
    }

    public function getDescription(): string
    {
        return 'A clean, minimalist design focusing on essential information.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.minimal';
    }
}
