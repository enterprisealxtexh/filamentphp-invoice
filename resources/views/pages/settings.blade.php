<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex gap-3 pt-8">
            <x-filament::button type="submit">
                {{ trans('filament-invoices::messages.settings.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
