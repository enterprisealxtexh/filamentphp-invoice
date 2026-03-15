<?php

namespace Alxtexh\FilamentInvoices\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceMeta extends Model
{
    protected $fillable = [
        'invoice_id',
        'key',
        'value',
        'type',
        'group',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
