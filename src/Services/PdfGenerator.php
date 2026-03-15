<?php

namespace Alxtexh\FilamentInvoices\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Alxtexh\FilamentInvoices\Models\Invoice;
use Alxtexh\FilamentInvoices\Services\Templates\TemplateFactory;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

class PdfGenerator
{
    protected InvoiceSettings $settings;

    public function __construct()
    {
        $this->settings = app(InvoiceSettings::class);
    }

    public function generate(Invoice $invoice, ?string $templateName = null, array $options = []): string
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        return $pdf->output();
    }

    public function stream(Invoice $invoice, ?string $templateName = null, array $options = []): SymfonyResponse
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        return $pdf->stream($this->getFilename($invoice));
    }

    public function download(Invoice $invoice, ?string $templateName = null, array $options = []): SymfonyResponse
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        return $pdf->download($this->getFilename($invoice));
    }

    public function save(Invoice $invoice, string $path, ?string $templateName = null, array $options = []): void
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        $pdf->save($path);
    }

    protected function getTemplate(?string $templateName = null): \Alxtexh\FilamentInvoices\Contracts\InvoiceTemplateInterface
    {
        $templateName = $templateName ?? $this->settings->default_template ?? 'classic';

        return TemplateFactory::make($templateName);
    }

    protected function configurePdf($pdf): void
    {
        $paperSize = $this->settings->paper_size ?? 'a4';

        $pdf->setPaper($paperSize, 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'DejaVu Sans');
    }

    protected function getFilename(Invoice $invoice): string
    {
        $companyName = $this->settings->company_name ?: 'Invoice';
        $companyName = preg_replace('/[^a-zA-Z0-9]/', '-', $companyName);

        return sprintf('%s-Invoice-%s.pdf', $companyName, $invoice->uuid);
    }
}
