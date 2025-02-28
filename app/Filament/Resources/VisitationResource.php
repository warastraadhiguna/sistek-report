<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use App\Models\Activity;
use App\Models\Taxpayer;
use Filament\Forms\Form;
use App\Models\Visitation;
use Filament\Tables\Table;
use App\Models\RequestStatus;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\Traits\HasPermission;
use App\Filament\Resources\VisitationResource\Pages;

class VisitationResource extends Resource
{
    use HasPermission;
    protected static ?string $model = Visitation::class;
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationGroup = 'Main Menu';
    protected static function getResourceName(): string
    {
        return 'visitation';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Select::make('taxpayer_id')
                    ->label('Taxpayer')
                    ->relationship('taxpayer', 'name')
                    ->options(fn () => Taxpayer::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('technician_id')
                    ->label('Technician')
                    ->relationship('technician', 'name')
                    ->options(fn () => User::whereHas('role', fn ($query) => $query->where('name', 'technician'))->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('activity_id')
                    ->label('Activity')
                    ->relationship('activity', 'name')
                    ->options(fn () => Activity::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('request_status_id')
                    ->label('Request Status')
                    ->relationship('requestStatus', 'name')
                    ->options(fn () => RequestStatus::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                DateTimePicker::make('arrival_date')
                    ->label('Arrival Datetime')
                    ->displayFormat('d-m-Y H:i') // Format tampilan
                    ->format('Y-m-d H:i:00') // Format penyimpanan ke database
                    ->required(),
                DateTimePicker::make('return_date')
                    ->label('Return Datetime')
                    ->displayFormat('d-m-Y H:i') // Format tampilan
                    ->format('Y-m-d H:i:00') // Format penyimpanan ke database
                    ->required(),
                Textarea::make('detail')->label('Detail'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn ($record) => null)
            ->columns([
                TextColumn::make('taxpayer.name')->label('Taxpayer')->searchable(),
                TextColumn::make('technician.name')->label('Technician')->searchable(),
                TextColumn::make('activity.name')->label('Activity'),
                TextColumn::make('requestStatus.name')->label('Request Status'),
                TextColumn::make('arrival_date')
                    ->label('Date')
                    ->formatStateUsing(function ($state, $record) {
                        $arrival = $record->arrival_date
                            ? Carbon::parse($record->arrival_date)->format('d/m/Y H:i')
                            : '-';
                        $return = $record->return_date
                            ? Carbon::parse($record->return_date)->format('d/m/Y H:i')
                            : '-';
                        return "{$arrival} - {$return}";
                    })->wrap(),
                TextColumn::make('detail')->label('Detail')->wrap(),
                TextColumn::make('user.name')->label('User'),
            ])
            ->filters([
            Filter::make('arrival_date_filter')
                ->form([
                    DatePicker::make('from')
                        ->label('Dari tanggal')
                        ->default(Carbon::now()->format('Y-m-1')),
                    DatePicker::make('until')
                        ->label('Sampai tanggal')
                        ->default(Carbon::now()->format('Y-m-d')),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['from'],
                            fn (Builder $query, $date) =>
                            $query->whereDate('arrival_date', '>=', $date)
                        )
                        ->when(
                            $data['until'],
                            fn (Builder $query, $date) =>
                            $query->whereDate('arrival_date', '<=', $date)
                        );
                })
                ->indicateUsing(function (array $data): ?string {
                    if ($data['from'] ?? null && $data['until'] ?? null) {
                        return "Dari {$data['from']} sampai {$data['until']}";
                    } elseif ($data['from'] ?? null) {
                        return "Mulai dari {$data['from']}";
                    } elseif ($data['until'] ?? null) {
                        return "Sampai {$data['until']}";
                    }
                    return null;
                }),
            // Filter berdasarkan Activity
            Filter::make('activity_filter')
                ->form([
                    Select::make('activity')
                        ->label('Activity')
                        ->options(Activity::pluck('name', 'id'))
                        ->searchable(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when($data['activity'], function (Builder $query, $value) {
                        $query->where('activity_id', $value);
                    });
                })
                ->indicateUsing(function (array $data): ?string {
                    return isset($data['activity']) ? "Aktivitas: " . Activity::find($data['activity'])?->name : null;
                }),
            // Filter berdasarkan Request Status
            Filter::make('request_status_filter')
                ->form([
                    Select::make('request_status')
                        ->label('Request Status')
                        ->options(RequestStatus::pluck('name', 'id'))
                        ->searchable(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when($data['request_status'], function (Builder $query, $value) {
                        $query->where('request_status_id', $value);
                    });
                })
                ->indicateUsing(function (array $data): ?string {
                    return isset($data['request_status']) ? "Request Status: " . RequestStatus::find($data['request_status'])?->name : null;
                }),
            ])
            ->actions([
                Tables\Actions\Action::make('visitation_image')
                    ->label('Berkas')
                    ->icon('heroicon-o-photo')
                    ->color("info")
                    ->url(fn ($record) => route('filament.admin.resources.visitation-images.index', [
                        'visitation_id' => $record->id
                    ])) // 🔥 Mengarahkan ke halaman List SingleSupervision dengan filter
                    ->openUrlInNewTab(), // 🔥 Buka di tab baru
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
            'index' => Pages\ListVisitations::route('/'),
            'create' => Pages\CreateVisitation::route('/create'),
            'edit' => Pages\EditVisitation::route('/{record}/edit'),
        ];
    }
}