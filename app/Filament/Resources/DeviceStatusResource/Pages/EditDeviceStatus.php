<?php

namespace App\Filament\Resources\DeviceStatusResource\Pages;

use App\Filament\Resources\DeviceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceStatus extends EditRecord
{
    protected static string $resource = DeviceStatusResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah create
        return $this->getResource()::getUrl('index');
    }
}