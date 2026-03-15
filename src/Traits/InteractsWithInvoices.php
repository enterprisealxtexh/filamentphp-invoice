<?php

namespace Alxtexh\FilamentInvoices\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Alxtexh\FilamentInvoices\Models\Invoice;

trait InteractsWithInvoices
{
    public function invoicesFor(): MorphMany
    {
        return $this->morphMany(Invoice::class, 'for');
    }

    public function invoicesFrom(): MorphMany
    {
        return $this->morphMany(Invoice::class, 'from');
    }
}
