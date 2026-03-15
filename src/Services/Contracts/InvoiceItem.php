<?php

namespace Alxtexh\FilamentInvoices\Services\Contracts;

class InvoiceItem
{
    public string $item;

    public ?string $description = null;

    public float $qty = 1;

    public float $price = 0;

    public float $discount = 0;

    public float $vat = 0;

    public ?array $options = null;

    public static function make(string $item): static
    {
        $static = new static;
        $static->item = $item;

        return $static;
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function qty(float $qty): static
    {
        $this->qty = $qty;

        return $this;
    }

    public function price(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function discount(float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function vat(float $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }
}
