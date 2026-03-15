<?php

namespace Alxtexh\FilamentInvoices\Pages;

use Filament\Schemas;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Alxtexh\FilamentInvoices\Services\Templates\TemplateFactory;
use Alxtexh\FilamentInvoices\Settings\InvoiceSettings;

class InvoiceSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament-invoices::pages.settings';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return trans('filament-invoices::messages.settings.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-invoices::messages.invoices.group');
    }

    public function mount(): void
    {
        $settings = app(InvoiceSettings::class);
        $this->form->fill([
            'company_name' => $settings->company_name,
            'company_email' => $settings->company_email,
            'company_phone' => $settings->company_phone,
            'company_address' => $settings->company_address,
            'company_logo' => $settings->company_logo,
            'default_currency' => $settings->default_currency,
            'default_template' => $settings->default_template,
            'default_payment_terms' => $settings->default_payment_terms,
            'default_tax_rate' => $settings->default_tax_rate,
            'invoice_prefix' => $settings->invoice_prefix,
            'email_subject_template' => $settings->email_subject_template,
            'email_body_template' => $settings->email_body_template,
            'email_cc' => $settings->email_cc,
            'email_bcc' => $settings->email_bcc,
            'paper_size' => $settings->paper_size,
            'include_terms' => $settings->include_terms,
            'terms_text' => $settings->terms_text,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                SchemaComponents\Tabs::make('Settings')
                    ->tabs([
                        SchemaComponents\Tabs\Tab::make(trans('filament-invoices::messages.settings.sections.company'))
                            ->schema([
                                Components\TextInput::make('company_name')
                                    ->label(trans('filament-invoices::messages.settings.columns.company_name'))
                                    ->required(),
                                Components\TextInput::make('company_email')
                                    ->label(trans('filament-invoices::messages.settings.columns.company_email'))
                                    ->email(),
                                Components\TextInput::make('company_phone')
                                    ->label(trans('filament-invoices::messages.settings.columns.company_phone')),
                                Components\Textarea::make('company_address')
                                    ->label(trans('filament-invoices::messages.settings.columns.company_address'))
                                    ->rows(3),
                                Components\FileUpload::make('company_logo')
                                    ->label(trans('filament-invoices::messages.settings.columns.company_logo'))
                                    ->image()
                                    ->directory('invoices/logos'),
                            ]),
                        SchemaComponents\Tabs\Tab::make(trans('filament-invoices::messages.settings.sections.defaults'))
                            ->schema([
                                Components\Select::make('default_currency')
                                    ->label(trans('filament-invoices::messages.settings.columns.default_currency'))
                                    ->options([
                                        'KES' => 'KES - Kenyan Shilling',
                                        'USD' => 'USD - US Dollar',
                                        'EUR' => 'EUR - Euro',
                                        'GBP' => 'GBP - British Pound',
                                        'TZS' => 'TZS - Tanzanian Shilling',
                                        'UGX' => 'UGX - Ugandan Shilling',
                                        'ZAR' => 'ZAR - South African Rand',
                                        'NGN' => 'NGN - Nigerian Naira',
                                        'INR' => 'INR - Indian Rupee',
                                        'AED' => 'AED - UAE Dirham',
                                    ]),
                                Components\Select::make('default_template')
                                    ->label(trans('filament-invoices::messages.settings.columns.default_template'))
                                    ->options(fn () => TemplateFactory::getOptions()),
                                Components\TextInput::make('default_payment_terms')
                                    ->label(trans('filament-invoices::messages.settings.columns.default_payment_terms'))
                                    ->numeric()
                                    ->suffix('days'),
                                Components\TextInput::make('default_tax_rate')
                                    ->label(trans('filament-invoices::messages.settings.columns.default_tax_rate'))
                                    ->numeric()
                                    ->suffix('%'),
                                Components\TextInput::make('invoice_prefix')
                                    ->label(trans('filament-invoices::messages.settings.columns.invoice_prefix'))
                                    ->default('INV-'),
                            ]),
                        SchemaComponents\Tabs\Tab::make(trans('filament-invoices::messages.settings.sections.email'))
                            ->schema([
                                Components\TextInput::make('email_subject_template')
                                    ->label(trans('filament-invoices::messages.settings.columns.email_subject_template'))
                                    ->helperText('Available placeholders: {uuid}, {company_name}, {customer_name}, {total}, {currency}, {due_date}'),
                                Components\Textarea::make('email_body_template')
                                    ->label(trans('filament-invoices::messages.settings.columns.email_body_template'))
                                    ->helperText('Available placeholders: {uuid}, {company_name}, {customer_name}, {total}, {currency}, {due_date}')
                                    ->rows(5),
                                Components\TextInput::make('email_cc')
                                    ->label(trans('filament-invoices::messages.settings.columns.email_cc'))
                                    ->email(),
                                Components\TextInput::make('email_bcc')
                                    ->label(trans('filament-invoices::messages.settings.columns.email_bcc'))
                                    ->email(),
                            ]),
                        SchemaComponents\Tabs\Tab::make(trans('filament-invoices::messages.settings.sections.pdf'))
                            ->schema([
                                Components\Select::make('paper_size')
                                    ->label(trans('filament-invoices::messages.settings.columns.pdf_paper_size'))
                                    ->options([
                                        'a4' => 'A4',
                                        'letter' => 'Letter',
                                        'legal' => 'Legal',
                                    ]),
                                Components\Toggle::make('include_terms')
                                    ->label('Include Terms & Conditions'),
                                Components\Textarea::make('terms_text')
                                    ->label('Terms & Conditions Text')
                                    ->rows(4),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = app(InvoiceSettings::class);

        $settings->company_name = $data['company_name'] ?? '';
        $settings->company_email = $data['company_email'] ?? '';
        $settings->company_phone = $data['company_phone'] ?? '';
        $settings->company_address = $data['company_address'] ?? '';
        $settings->company_logo = $data['company_logo'] ?? '';
        $settings->default_currency = $data['default_currency'] ?? 'KES';
        $settings->default_template = $data['default_template'] ?? 'classic';
        $settings->default_payment_terms = (int) ($data['default_payment_terms'] ?? 30);
        $settings->default_tax_rate = (float) ($data['default_tax_rate'] ?? 0);
        $settings->invoice_prefix = $data['invoice_prefix'] ?? 'INV-';
        $settings->email_subject_template = $data['email_subject_template'] ?? '';
        $settings->email_body_template = $data['email_body_template'] ?? '';
        $settings->email_cc = $data['email_cc'] ?? '';
        $settings->email_bcc = $data['email_bcc'] ?? '';
        $settings->paper_size = $data['paper_size'] ?? 'a4';
        $settings->include_terms = $data['include_terms'] ?? true;
        $settings->terms_text = $data['terms_text'] ?? '';
        $settings->save();

        Notification::make()
            ->title(trans('filament-invoices::messages.settings.saved'))
            ->success()
            ->send();
    }
}
