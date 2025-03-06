<?php

namespace App\Filament\Resources;

use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Permission;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Traits\HasPermission;
use App\Filament\Resources\PermissionResource\Pages;

class PermissionResource extends Resource
{
    use HasPermission;
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-circle';

    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'permission';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('roles', 'permissions.role_id', '=', 'roles.id')
            ->join('resources', 'permissions.resource_id', '=', 'resources.id')
            ->select('permissions.*') // pastikan hanya memilih field utama untuk model
            ->orderBy('roles.name', 'asc')
            ->orderBy('resources.name', 'asc');
    }
    public static function getRecordRouteKeyName(): string
    {
        return 'permissions.id'; // Gunakan alias yang kita buat di query
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Select::make('role_id')
                    ->label('Role')
                    ->relationship('role', 'name')
                    ->options(fn () => Role::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('resource_id')
                    ->label('Fitur')
                    ->relationship('resource', 'name')
                    ->options(fn () => \App\Models\Resource::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('can_view_any')
                    ->label('Read')
                    ->options(['0' => 'No', '1' => 'Yes'])
                    ->default('0')
                    ->required(),
                Select::make('can_create')
                    ->label('Create')
                    ->options(['0' => 'No', '1' => 'Yes'])
                    ->default('0')
                    ->required(),
                Select::make('can_edit')
                    ->label('Edit')
                    ->options(['0' => 'No', '1' => 'Yes'])
                    ->default('0')
                    ->required(),
                Select::make('can_delete')
                    ->label('Delete')
                    ->options(['0' => 'No', '1' => 'Yes'])
                    ->default('0')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn ($record) => null)
            ->columns([
                TextColumn::make('role.name')->label('Role')->searchable(),
                TextColumn::make('resource.name')->label('Fitur')->searchable(),
                IconColumn::make('can_view_any')->label('Read')->boolean(),
                IconColumn::make('can_create')->label('Create')->boolean(),
                IconColumn::make('can_edit')->label('Update')->boolean(),
                IconColumn::make('can_delete')->label('Delete')->boolean(),
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}