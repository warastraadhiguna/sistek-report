<?php

namespace App\Filament\Resources\DeviceDetailResource\Pages;

use App\Filament\Resources\DeviceDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceDetails extends ListRecords
{
    protected static string $resource = DeviceDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
