<?php

namespace App\Filament\Resources\TaxpayerResource\Pages;

use App\Filament\Resources\TaxpayerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxpayer extends EditRecord
{
    protected static string $resource = TaxpayerResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah create
        return $this->getResource()::getUrl('index');
    }
}