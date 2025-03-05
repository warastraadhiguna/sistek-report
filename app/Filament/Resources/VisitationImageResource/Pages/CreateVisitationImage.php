<?php

namespace App\Filament\Resources\VisitationImageResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\VisitationImageResource;

class CreateVisitationImage extends CreateRecord
{
    protected static string $resource = VisitationImageResource::class;


    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Create')
                ->color('primary')
                ->action('create'),
            Action::make('cancel')
                ->label('Cancel')
                ->color('primary')
                ->url($this->getResource()::getUrl('index', [
                'visitation_id' => request('visitation_id'), // 🔥 Meneruskan parameter
            ]))
                ->extraAttributes(['class' => 'bg-gray-400 hover:bg-gray-300'])
        ];
    }

    protected function getRedirectUrl(): string
    {
        $visitationId = $this->record->visitation_id ??  request('visitation_id');

        // Redirect ke halaman index setelah create

        return $this->getResource()::getUrl('index', [
                'visitation_id' => $visitationId, // 🔥 Meneruskan parameter
            ]);

    }
}
