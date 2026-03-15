<?php

use Illuminate\Support\Facades\Route;
use Alxtexh\FilamentInvoices\Models\Invoice;
use Alxtexh\FilamentInvoices\Services\PdfGenerator;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/invoices/{invoice}/print', function (Invoice $invoice) {
        $settings = app(InvoiceSettings::class);
        $template = request()->query('template', $settings->default_template ?? 'classic');
        $pdfGenerator = app(PdfGenerator::class);

        return $pdfGenerator->stream($invoice, $template);
    })->name('filament-invoices.print');

    Route::get('/invoices/{invoice}/download', function (Invoice $invoice) {
        $settings = app(InvoiceSettings::class);
        $template = request()->query('template', $settings->default_template ?? 'classic');
        $pdfGenerator = app(PdfGenerator::class);

        return $pdfGenerator->download($invoice, $template);
    })->name('filament-invoices.download');
});
