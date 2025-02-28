<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\DeviceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Create')
                ->color('primary')
                ->action('create')
                ->extraAttributes(['type' => 'submit']),
            Action::make('cancel')
                ->label('Cancel')
                ->color('primary')
        ->url($this->getResource()::getUrl('index'))
                ->extraAttributes(['class' => 'bg-gray-400 hover:bg-gray-300'])
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah create
        return $this->getResource()::getUrl('index');
    }
}