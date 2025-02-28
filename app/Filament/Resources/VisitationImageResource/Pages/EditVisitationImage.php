<?php

namespace App\Filament\Resources\VisitationImageResource\Pages;

use Filament\Actions;
use App\Models\Visitation;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\VisitationImageResource;

class EditVisitationImage extends EditRecord
{
    protected static string $resource = VisitationImageResource::class;
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->color('primary')
                ->action('save'),
            Action::make('cancel')
                ->label('Cancel')
                ->color('primary')
                ->url($this->getResource()::getUrl('index', [
                        'visitation_id' => $this->record->visitation_id, // 🔥 Meneruskan parameter
                    ]))
                ->extraAttributes(['class' => 'bg-gray-400 hover:bg-gray-300']),
        ];
    }
    protected function getRedirectUrl(): string
    {
        $visitationId = $this->record->visitation_id;

        // Redirect ke halaman index setelah create

        return $this->getResource()::getUrl('index', [
                'visitation_id' => $visitationId, // 🔥 Meneruskan parameter
            ]);
    }

    protected function beforeFill(): void
    {
        $visitationId = $this->record->visitation_id;

        if (!$visitationId) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $visitation = Visitation::where('id', $visitationId)
            ->first();

        if (!$visitation) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}