<?php

namespace App\Filament\Resources;

use App\Models\Taxpayer;
use Filament\Tables;
use App\Models\Device;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeviceDetail;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\Traits\HasPermission;

class DeviceResource extends Resource
{
    use HasPermission;
    protected static ?string $model = Device::class;
    protected static ?string $navigationIcon = 'heroicon-o-device-tablet';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'device';
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('taxpayers', 'devices.taxpayer_id', '=', 'taxpayers.id')
            ->join('device_details', 'devices.device_detail_id', '=', 'device_details.id')
            ->join('device_types', 'device_details.device_type_id', '=', 'device_types.id')
            ->select('devices.*') // pastikan hanya memilih field utama untuk model
            ->orderBy('taxpayers.name', 'asc')
            ->orderBy('device_types.name', 'asc')
            ->orderBy('device_details.name', 'asc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('taxpayer_id')
                    ->label('Taxpayer')
                    ->relationship('taxpayer', 'name')
                    ->options(fn () => Taxpayer::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                    Select::make('device_detail_id')
                        ->label('Device Detail')
                        ->options(fn () => DeviceDetail::with('deviceType')
                            ->get()
                            ->mapWithKeys(function ($deviceDetail) {
                                return [
                                    $deviceDetail->id => $deviceDetail->deviceType->name . ' - ' . $deviceDetail->name,
                                ];
                            })
                            ->toArray())
                        ->searchable()
                        ->required(),
                TextInput::make('serial_number')->label('Serial Number'),
                Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn ($record) => null)
            ->columns([
                TextColumn::make('taxpayer.name')->label('Nama Taxpayer')->searchable(),
                TextColumn::make('deviceDetail.deviceType.name')->label('Nama Type Device')->searchable(),
                TextColumn::make('deviceDetail.name')->label('Nama Detail Device')->searchable(),
                TextColumn::make('serial_number')->label('Serial Number')->searchable(),
                TextColumn::make('user.name')->label('User'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}