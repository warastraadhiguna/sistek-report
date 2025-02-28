<?php

namespace App\Filament\Resources\DeviceDetailResource\Pages;

use App\Filament\Resources\DeviceDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceDetail extends EditRecord
{
    protected static string $resource = DeviceDetailResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah create
        return $this->getResource()::getUrl('index');
    }
}