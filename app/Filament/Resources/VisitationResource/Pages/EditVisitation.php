<?php

namespace App\Filament\Resources\VisitationResource\Pages;

use App\Filament\Resources\VisitationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisitation extends EditRecord
{
    protected static string $resource = VisitationResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah create
        return $this->getResource()::getUrl('index');
    }
}