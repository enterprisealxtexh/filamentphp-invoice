<?php

namespace Alxtexh\FilamentInvoices\Settings;

use Spatie\LaravelSettings\Settings;

class InvoiceSettings extends Settings
{
    public string $company_name;

    public ?string $company_logo;

    public string $company_address;

    public string $company_phone;

    public string $company_email;

    public string $company_tax_id;

    public string $default_currency;

    public float $default_tax_rate;

    public int $default_payment_terms;

    public string $email_subject_template;

    public string $email_body_template;

    public ?string $email_cc;

    public ?string $email_bcc;

    public string $email_from_name;

    public string $email_from_email;

    public string $default_template;

    public string $invoice_prefix;

    public string $paper_size;

    public bool $include_terms;

    public string $terms_text;

    public static function group(): string
    {
        return 'invoices';
    }
}
