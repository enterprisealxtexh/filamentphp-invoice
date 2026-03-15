# Filament Invoice Plugin (v5)

A complete invoice management plugin for [Filament PHP](https://filamentphp.com/) v5, supporting invoices, receipts, and consultation invoices with PDF generation, email delivery, and professional templates.

## Features

✨ **Complete Invoice Management**
- Create, read, update, delete invoices with soft deletes
- Polymorphic relationships for flexible billing (Bill From/To any model)
- Real-time total calculations with tax, discount, and shipping
- Activity logging for all invoice actions

📄 **PDF Generation & Templates**
- 6 professional templates included: Classic, Modern, Minimal, Professional, Creative, Pay-Slip
- Customizable paper sizes and orientations
- Print-friendly inline view rendering
- DomPDF powered with Blade templating

📧 **Email Integration**
- Send invoices via email with PDF attachment
- Customizable email templates with placeholders
- Bulk email actions for multiple invoices
- CC/BCC support with smart defaults

💰 **Financial Features**
- Multi-currency support (KES, USD, EUR, GBP, TZS, UGX, ZAR, NGN, INR, AED)
- Item-level discounts, VAT, and shipping costs
- Payment tracking (paid amount vs total)
- Invoice status workflow (draft, sent, paid, overdue, cancelled)

⚙️ **Settings Hub**
- Centralized configuration using Spatie Laravel Settings
- Company branding (logo, name, address, contact)
- Default currency, tax rate, payment terms
- Email templates with variable substitution
- PDF settings and Terms & Conditions

🎨 **Filament v5 Integration**
- Full-featured Resource with forms, tables, and filters
- Stats widget showing key metrics
- Relation managers for activity logs and payments
- List/Create/Edit/View pages with header actions
- Bulk actions (status change, export, email)
- Row actions (pay, export, email, delete)

## Installation

1. Require the package via Composer:
```bash
composer require alxtexh/filament-invoices
```

2. Run migrations:
```bash
php artisan migrate
```

3. Register the plugin in your Filament panel (`app/Providers/Filament/AdminPanelProvider.php`):
```php
use Alxtexh\FilamentInvoices\FilamentInvoicesPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilamentInvoicesPlugin::make())
        // ...
}
```

4. Register your Bill From/To models in `app/Providers/AppServiceProvider.php`:
```php
use Alxtexh\FilamentInvoices\Facades\FilamentInvoices;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceFor;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceFrom;
use App\Models\User;

public function boot(): void
{
    FilamentInvoices::registerFrom(
        InvoiceFrom::make(User::class)->label('Seller')->column('name')
    );
    
    FilamentInvoices::registerFor(
        InvoiceFor::make(User::class)->label('Customer')->column('name')
    );
}
```

5. Access invoices at `/admin/invoices` (after Filament installation)

## Usage

### Create an Invoice Programmatically

```php
use Alxtexh\FilamentInvoices\Services\CreateInvoice;
use Alxtexh\FilamentInvoices\Services\Contracts\InvoiceItem;

$invoice = app(CreateInvoice::class)
    ->from(User::find(1))
    ->for(User::find(2))
    ->items([
        InvoiceItem::make('Web Development')
            ->price(1000)
            ->qty(1)
            ->vat(160),
    ])
    ->save();
```

### Generate PDF

```php
use Alxtexh\FilamentInvoices\Services\PdfGenerator;

$pdf = app(PdfGenerator::class)
    ->generate($invoice, 'modern'); // template name

// Download
return response()->streamDownload(
    fn () => echo $pdf,
    'invoice.pdf'
);
```

### Send via Email

```php
use Alxtexh\FilamentInvoices\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

Mail::to('customer@example.com')->send(
    new InvoiceMail(
        invoice: $invoice,
        template: 'modern',
        subject: 'Your Invoice',
        body: 'Please find attached invoice...'
    )
);
```

## Configuration

Publish the config file:
```bash
php artisan vendor:publish --tag=filament-invoices-config
```

Edit `config/filament-invoices.php` to customize:
- Available currencies
- Invoice statuses and types
- Status colors and icons
- PDF settings

## Database Tables

- `invoices` - Main invoice records
- `invoices_items` - Line items
- `invoice_metas` - Key-value metadata
- `invoice_logs` - Activity audit trail
- `settings` - Spatie settings (company info, email templates, etc.)

## Models

### Invoice
```php
$invoice->from_type     // Billable class (e.g., User)
$invoice->from_id       // Billable ID
$invoice->for_type      // Customer class
$invoice->for_id        // Customer ID
$invoice->uuid          // Unique identifier
$invoice->date          // Invoice date
$invoice->due_date      // Payment deadline
$invoice->status        // draft|sent|paid|overdue|cancelled
$invoice->type          // Invoice type
$invoice->currency      // Currency code
$invoice->total         // Grand total
$invoice->paid          // Amount paid
$invoice->discount      // Total discount
$invoice->vat           // Total tax
$invoice->shipping      // Shipping costs
$invoice->notes         // Special notes

// Relations
$invoice->invoicesItems()  // Line items
$invoice->invoiceMetas()   // Metadata
$invoice->invoiceLogs()    // Activity log
```

## Translation

Publish language files:
```bash
php artisan vendor:publish --tag=filament-invoices-lang
```

Edit `resources/lang/vendor/filament-invoices/en/messages.php`

## Templates

Override blade templates by publishing:
```bash
php artisan vendor:publish --tag=filament-invoices-views
```

Templates are located in `resources/views/vendor/filament-invoices/`

## License

MIT License - see LICENSE.md

## Support

For issues and feature requests, visit the [GitHub repository](https://github.com/enterprisealxtexh/filamentphp-invoice)

## Credits

Forked from [TomatoPHP/filament-invoices](https://github.com/tomatophp/filament-invoices) and upgraded for Filament v5 compatibility with enhanced features and removed external dependencies.
