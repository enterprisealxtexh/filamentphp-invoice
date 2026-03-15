<?php

namespace Alxtexh\FilamentInvoices\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLog extends Model
{
    protected $fillable = [
        'invoice_id',
        'log',
        'type',
    ];

    protected $casts = [
        'log' => 'json',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
