<?php

namespace Alxtexh\FilamentInvoices\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Alxtexh\FilamentInvoices\Models\Invoice;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceItem;

class CreateInvoice
{
    public string $for_type;

    public string $for_id;

    public string $from_type;

    public string $from_id;

    public ?string $name = null;

    public ?string $phone = null;

    public ?string $address = null;

    public ?Carbon $due_date = null;

    public ?Carbon $date = null;

    public ?string $status = 'draft';

    public ?string $type = 'push';

    public ?string $currency = 'KES';

    public ?string $notes = null;

    public float $shipping = 0;

    public array $items = [];

    public function for(Model $for): static
    {
        $this->for_type = get_class($for);
        $this->for_id = $for->id;
        $this->name = $for->name ?? '';
        $this->phone = $for->phone ?? null;
        $this->address = $for->address ?? null;

        return $this;
    }

    public function from(Model $from): static
    {
        $this->from_type = get_class($from);
        $this->from_id = $from->id;

        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function phone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function address(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function dueDate(Carbon $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function date(Carbon $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function shipping(float $shipping): static
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function status(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function notes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function items(array|InvoiceItem $items): static
    {
        if (is_array($items)) {
            foreach ($items as $item) {
                $this->items[] = $item;
            }
        } else {
            $this->items[] = $items;
        }

        return $this;
    }

    public function save(): Invoice
    {
        $invoiceNumber = strtoupper(\Illuminate\Support\Str::random(8));
        
        $invoice = Invoice::create([
            'uuid' => 'INV-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'invoice_number' => 'INV-' . $invoiceNumber,
            'for_type' => $this->for_type,
            'for_id' => $this->for_id,
            'from_type' => $this->from_type,
            'from_id' => $this->from_id,
            'user_id' => $this->from_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'client_name' => $this->name ?? '',
            'client_email' => '',
            'client_phone' => $this->phone ?? '',
            'client_address' => $this->address ?? '',
            'service_description' => '',
            'amount' => 0,
            'total_amount' => 0,
            'due_date' => $this->due_date ?? now()->addDays(30),
            'date' => $this->date ?? now(),
            'status' => $this->status,
            'type' => $this->type,
            'currency' => $this->currency,
            'shipping' => $this->shipping,
            'notes' => $this->notes,
        ]);

        $totalDiscount = 0;
        $totalVat = 0;
        $totalAmount = 0;

        foreach ($this->items as $item) {
            $itemTotal = (($item->price + $item->vat) - $item->discount) * $item->qty;

            $invoice->invoicesItems()->create([
                'item' => $item->item,
                'description' => $item->description,
                'qty' => $item->qty,
                'price' => $item->price,
                'discount' => $item->discount,
                'vat' => $item->vat,
                'total' => $itemTotal,
                'options' => $item->options,
            ]);

            $totalDiscount += ($item->discount * $item->qty);
            $totalVat += ($item->vat * $item->qty);
            $totalAmount += $itemTotal;
        }

        $invoice->update([
            'discount' => $totalDiscount,
            'vat' => $totalVat,
            'total' => $totalAmount + $this->shipping,
            'amount' => $totalAmount,
            'total_amount' => $totalAmount + $this->shipping,
        ]);

        return $invoice->fresh();
    }
}
