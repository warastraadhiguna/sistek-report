<x-filament-panels::page>
    <form wire:submit="save" class="space-y-4">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">
                Update Password
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>