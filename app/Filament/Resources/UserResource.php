<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\Traits\HasPermission;

class UserResource extends Resource
{
    use HasPermission;
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'user';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('role', function ($query) {
                $query->whereNot('name', 'technician');
            });
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama')->required(),
                TextInput::make('email')->label('Email')->required(),
                Select::make('role_id')
                    ->label('Role')
                    ->relationship('role', 'name')
                    ->options(fn () => \App\Models\Role::whereNot('name', 'technician')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
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
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->recordUrl(fn ($record) => null)
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('role.name')->label('Role'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}