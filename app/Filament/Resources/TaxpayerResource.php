<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Taxpayer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Traits\HasPermission;
use App\Filament\Resources\TaxpayerResource\Pages;

class TaxpayerResource extends Resource
{
    use HasPermission;

    protected static ?string $model = Taxpayer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'taxpayer';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')->label('Nomor Taypayer'),
                TextInput::make('name')->label('Nama')->required(),
                TextInput::make('business_name')->label('Nama Bisnis'),
                Textarea::make('address')->label('Alamat')->required(),
                TextInput::make('email')->label('Email'),
                TextInput::make('phone')->label('No telepon')->required(),
                Textarea::make('note')->label('Catatan'),
                Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Nomor')->searchable(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('business_name')->label('Nama Bisnis')->searchable(),
                TextColumn::make('address')->label('Alamat')->wrap(),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('phone')->label('No Telepon'),
                TextColumn::make('note')->label('Catatan')->wrap(),
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
            ])
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListTaxpayers::route('/'),
            'create' => Pages\CreateTaxpayer::route('/create'),
            'edit' => Pages\EditTaxpayer::route('/{record}/edit'),
        ];
    }
}