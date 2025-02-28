<?php

namespace App\Filament\Resources\VisitationImageResource\Pages;

use Filament\Actions;
use App\Models\Visitation;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\VisitationImageResource;

class ListVisitationImages extends ListRecords
{
    protected static string $resource = VisitationImageResource::class;

    protected function getHeaderActions(): array
    {

        return [
        CreateAction::make()
            ->url(fn () => route('filament.admin.resources.visitation-images.create', ['visitation_id' => request('visitation_id')]))
        ];
    }

    public function mount(): void
    {
        $visitationId = request('visitation_id');
        if (!$visitationId) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.'); // ❌ Forbidden jika tidak sesuai
        }
        if ($visitationId) {
            $visitation = Visitation::where('id', $visitationId)
                ->first();
            if (!$visitation) {
                abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.'); // ❌ Forbidden jika tidak sesuai
            }
        }
    }
}