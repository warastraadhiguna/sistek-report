<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Traits\HasPermission;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TechnicianResource\Pages;

class TechnicianResource extends Resource
{
    use HasPermission;
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'technician';
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('role', function ($query) {
                $query->where('name', 'technician');
            });
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama')->required(),
                TextInput::make('email')->label('Email')->required(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof CreateRecord) // Wajib diisi hanya saat membuat user baru
                    ->dehydrated(fn ($state) => filled($state)) // Hanya menyimpan password jika ada input
                    ->afterStateHydrated(fn ($state, callable $set) => $set('password', '')) // Kosongkan setelah load data
                    ->maxLength(255),
                Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Hidden::make('role_id')
                    ->default(fn () => Role::where('name', 'technician')->value('id'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('email')->label('Email'),
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
            'index' => Pages\ListTechnicians::route('/'),
            'create' => Pages\CreateTechnician::route('/create'),
            'edit' => Pages\EditTechnician::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Technician';
    }

    public static function getModelLabel(): string
    {
        return __('Technician'); // Label singular
    }

    public static function getPluralModelLabel(): string
    {
        return __('Data Technician'); // Label plural
    }
}