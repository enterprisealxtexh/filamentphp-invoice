<?php

namespace Alxtexh\FilamentInvoices\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Alxtexh\FilamentInvoices\Models\Invoice;
use Alxtexh\FilamentInvoices\Services\PdfGenerator;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

class InvoiceMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected InvoiceSettings $settings;

    protected ?string $template;

    protected ?string $customSubject;

    protected ?string $customBody;

    protected array $ccAddresses = [];

    protected array $bccAddresses = [];

    public function __construct(
        public Invoice $invoice,
        ?string $template = null,
        ?string $cc = null,
        ?string $bcc = null,
        ?string $subject = null,
        ?string $body = null,
    ) {
        $this->settings = app(InvoiceSettings::class);
        $this->template = $template;
        $this->customSubject = $subject;
        $this->customBody = $body;

        if ($cc) {
            $this->ccAddresses = array_filter(array_map('trim', explode(',', $cc)));
        }
        if ($bcc) {
            $this->bccAddresses = array_filter(array_map('trim', explode(',', $bcc)));
        }
    }

    public function envelope(): Envelope
    {
        $subject = $this->customSubject ?? $this->settings->email_subject_template ?? 'Invoice #{uuid}';
        $subject = $this->replacePlaceholders($subject);

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $body = $this->customBody ?? $this->settings->email_body_template ?? '';
        $body = $this->replacePlaceholders($body);

        return new Content(
            view: 'filament-invoices::emails.invoice',
            with: [
                'invoice' => $this->invoice,
                'settings' => $this->settings,
                'emailBody' => $body,
            ],
        );
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        $pdfGenerator = app(PdfGenerator::class);
        $pdfContent = $pdfGenerator->generate($this->invoice, $this->template);

        $companyName = $this->settings->company_name ?: 'Invoice';
        $companyName = preg_replace('/[^a-zA-Z0-9]/', '-', $companyName);
        $filename = sprintf('%s-Invoice-%s.pdf', $companyName, $this->invoice->uuid);

        return [
            Attachment::fromData(fn () => $pdfContent, $filename)
                ->withMime('application/pdf'),
        ];
    }

    public function build(): self
    {
        if (! empty($this->ccAddresses)) {
            $this->cc($this->ccAddresses);
        }

        if (! empty($this->bccAddresses)) {
            $this->bcc($this->bccAddresses);
        }

        $fromName = $this->settings->email_from_name ?: config('app.name');
        $fromEmail = $this->settings->email_from_email ?: config('mail.from.address');

        if ($fromEmail) {
            $this->from($fromEmail, $fromName);
        }

        return $this;
    }

    protected function replacePlaceholders(string $text): string
    {
        $customerName = $this->invoice->name ?? 'Customer';

        return str_replace(
            ['{uuid}', '{company_name}', '{customer_name}', '{total}', '{currency}', '{due_date}'],
            [
                $this->invoice->uuid,
                $this->settings->company_name ?? config('app.name'),
                $customerName,
                number_format($this->invoice->total, 2),
                $this->invoice->currency ?? $this->settings->default_currency ?? 'KES',
                $this->invoice->due_date?->format('Y-m-d') ?? 'N/A',
            ],
            $text
        );
    }
}
