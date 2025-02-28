<?php

namespace App\Filament\Resources\RequestStatusResource\Pages;

use App\Filament\Resources\RequestStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestStatus extends EditRecord
{
    protected static string $resource = RequestStatusResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah create
        return $this->getResource()::getUrl('index');
    }
}