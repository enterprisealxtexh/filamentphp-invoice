<?php

namespace Alxtexh\FilamentInvoices\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceFor;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceFrom;

/**
 * @method static void registerFrom(array|InvoiceFrom $from)
 * @method static void registerFor(array|InvoiceFor $for)
 * @method static Collection getFrom()
 * @method static Collection getFor()
 * @method static \Alxtexh\FilamentInvoices\Services\CreateInvoice create()
 * @method static array getStatuses()
 * @method static array getStatusColors()
 * @method static array getStatusIcons()
 * @method static array getTypes()
 */
class FilamentInvoices extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filament-invoices';
    }
}
