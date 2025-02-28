<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\DeviceType;
use Filament\Tables\Table;
use App\Models\DeviceDetail;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Traits\HasPermission;
use App\Filament\Resources\DeviceDetailResource\Pages;

class DeviceDetailResource extends Resource
{
    use HasPermission;

    protected static ?string $model = DeviceDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'device-detail';
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('device_types', 'device_details.device_type_id', '=', 'device_types.id')
            ->select('device_details.*') // pastikan hanya memilih field utama untuk model
            ->orderBy('device_types.name', 'asc')
            ->orderBy('device_details.name', 'asc');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('device_type_id')
                    ->label('Device Type')
                    ->relationship('deviceType', 'name')
                    ->options(fn () => DeviceType::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('name')->label('Nama')->required(),
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
                TextColumn::make('deviceType.name')->label('Nama Type Device')->searchable(),
                TextColumn::make('name')->label('Nama')->searchable(),
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
            'index' => Pages\ListDeviceDetails::route('/'),
            'create' => Pages\CreateDeviceDetail::route('/create'),
            'edit' => Pages\EditDeviceDetail::route('/{record}/edit'),
        ];
    }
}