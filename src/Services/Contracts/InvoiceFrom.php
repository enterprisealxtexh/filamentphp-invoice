<?php

namespace Alxtexh\FilamentInvoices\Services\Contracts;

class InvoiceFrom
{
    public string $model;

    public string $label;

    public string $column;

    public static function make(string $model): static
    {
        $static = new static;
        $static->model = $model;
        $static->column = 'name';

        return $static;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }
}
