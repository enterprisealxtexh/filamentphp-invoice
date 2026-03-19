<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="mt-6 flex justify-start">
            <x-filament::button type="submit" size="lg">
                {{ trans('filament-invoices::messages.settings.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
