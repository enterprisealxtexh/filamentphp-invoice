<?php

namespace Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;
use Alxtexh\FilamentInvoices\Filament\Resources\InvoiceResource;
use Alxtexh\FilamentInvoices\Mail\InvoiceMail;
use Alxtexh\FilamentInvoices\Services\PdfGenerator;
use Alxtexh\FilamentInvoices\Services\Templates\TemplateFactory;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected string $view = 'filament-invoices::pages.view-invoice';

    protected function getHeaderActions(): array
    {
        $settings = app(InvoiceSettings::class);

        return [
            Actions\EditAction::make()->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()->icon('heroicon-o-trash'),
            Actions\Action::make('print')
                ->label(trans('filament-invoices::messages.invoices.actions.print'))
                ->icon('heroicon-o-printer')
                ->color('info')
                ->action(function () {
                    $this->js('window.print()');
                }),
            Actions\Action::make('export_pdf')
                ->label(trans('filament-invoices::messages.invoices.actions.export_pdf.label'))
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->form([
                    Forms\Components\Select::make('template')
                        ->label(trans('filament-invoices::messages.invoices.actions.export_pdf.template'))
                        ->options(fn () => TemplateFactory::getOptions())
                        ->default($settings->default_template ?? 'classic'),
                ])
                ->action(function (array $data) {
                    $pdfGenerator = app(PdfGenerator::class);
                    $this->record->invoiceLogs()->create([
                        'log' => 'Invoice PDF exported by: ' . auth()->user()->name,
                        'type' => 'export',
                    ]);
                    return response()->streamDownload(function () use ($pdfGenerator, $data) {
                        echo $pdfGenerator->generate($this->record, $data['template'] ?? null);
                    }, 'Invoice-' . $this->record->uuid . '.pdf', ['Content-Type' => 'application/pdf']);
                }),
            Actions\Action::make('send_email')
                ->label(trans('filament-invoices::messages.invoices.actions.send_email.label'))
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->form([
                    Forms\Components\TextInput::make('to')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.to'))
                        ->email()
                        ->required(),
                    Forms\Components\Select::make('template')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.template'))
                        ->options(fn () => TemplateFactory::getOptions())
                        ->default($settings->default_template ?? 'classic'),
                    Forms\Components\TextInput::make('subject')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.subject'))
                        ->default($settings->email_subject_template ?: 'Invoice #{uuid} from {company_name}'),
                    Forms\Components\Textarea::make('body')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.body'))
                        ->rows(5)
                        ->default($settings->email_body_template ?: ''),
                    Forms\Components\TextInput::make('cc')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.cc'))
                        ->default($settings->email_cc),
                    Forms\Components\TextInput::make('bcc')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.bcc'))
                        ->default($settings->email_bcc),
                ])
                ->action(function (array $data) {
                    Mail::to($data['to'])->send(new InvoiceMail(
                        invoice: $this->record,
                        template: $data['template'] ?? null,
                        cc: $data['cc'] ?? null,
                        bcc: $data['bcc'] ?? null,
                        subject: $data['subject'] ?? null,
                        body: $data['body'] ?? null,
                    ));
                    $this->record->invoiceLogs()->create([
                        'log' => 'Invoice emailed to ' . $data['to'] . ' by ' . auth()->user()->name,
                        'type' => 'email',
                    ]);
                    Notification::make()
                        ->title(trans('filament-invoices::messages.invoices.actions.email_sent.title'))
                        ->body(trans('filament-invoices::messages.invoices.actions.email_sent.body'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
