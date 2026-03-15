<?php

namespace Alxtexh\FilamentInvoices\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicesItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'type',
        'item_type',
        'item_id',
        'item',
        'description',
        'note',
        'qty',
        'price',
        'discount',
        'vat',
        'total',
        'returned_qty',
        'returned',
        'is_free',
        'is_returned',
        'options',
    ];

    protected $casts = [
        'is_free' => 'bool',
        'is_returned' => 'bool',
        'options' => 'json',
        'qty' => 'decimal:2',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
