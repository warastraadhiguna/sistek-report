<?php

namespace App\Filament\Resources\VisitationResource\Pages;

use App\Filament\Resources\VisitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitations extends ListRecords
{
    protected static string $resource = VisitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
