<?php

namespace Alxtexh\FilamentInvoices\Console;

use Illuminate\Console\Command;

class FilamentInvoicesInstall extends Command
{
    protected $signature = 'filament-invoices:install';

    protected $description = 'Install Filament Invoices package';

    public function handle(): int
    {
        $this->info('Installing Filament Invoices...');

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'filament-invoices-config',
            '--force' => true,
        ]);

        // Run migrations
        $this->call('migrate');

        $this->info('Filament Invoices installed successfully!');
        $this->newLine();
        $this->info('Next steps:');
        $this->line('1. Add the plugin to your Filament panel provider:');
        $this->line('   ->plugin(FilamentInvoicesPlugin::make())');
        $this->newLine();
        $this->line('2. Register your models in a service provider:');
        $this->line('   FilamentInvoices::registerFor(new InvoiceFor(model: User::class, label: "Customer", column: "name"));');
        $this->line('   FilamentInvoices::registerFrom(new InvoiceFrom(model: User::class, label: "Company", column: "name"));');

        return self::SUCCESS;
    }
}
