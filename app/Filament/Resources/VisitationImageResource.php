<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Visitation;
use Filament\Tables\Table;
use App\Models\VisitationImage;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Traits\HasPermission;
use App\Filament\Resources\VisitationImageResource\Pages;

class VisitationImageResource extends Resource
{
    use HasPermission;
    protected static ?string $model = VisitationImage::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'visitation-image';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->when(request('visitation_id'), function ($query) {
            $query->where('visitation_id', request('visitation_id'));
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Hidden::make('visitation_id')
                    ->default(fn () => request('visitation_id')) // 🔥 Ambil dari request
                    ->required(),
                TextInput::make('title')->label('Title')->required(),
                Textarea::make('note')->label('Note'),
                FileUpload::make('image')
                    ->label('Image')
                    ->directory('images/gallery') // Direktori penyimpanan di `storage/app/public`
                    ->image() // Validasi gambar
                    ->maxSize(2048)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn ($record) => null)
            ->header(function () {
                $visitation = Visitation::with('technician', 'taxpayer')->find(request('visitation_id'));

                return view('components.visitation-image', [
                    'visitation' => $visitation
                ]);
            })
            ->recordUrl(fn ($record) => null)
            ->columns([
                TextColumn::make('title')->label('Title')->searchable(['title']),
                ImageColumn::make('image')
                    ->label('Image')
                    ->size(50), // Ukuran gambar
                TextColumn::make('note')->label('Note')->searchable(['title']),
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
            'index' => Pages\ListVisitationImages::route('/'),
            'create' => Pages\CreateVisitationImage::route('/create'),
            'edit' => Pages\EditVisitationImage::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}