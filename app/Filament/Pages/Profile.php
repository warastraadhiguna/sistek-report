<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed'; // Ikon di sidebar
    protected static ?string $title = 'Password';
    protected static string $view = 'filament.pages.profile';
    protected static ?int $navigationSort = 2; // Urutan menu di sidebar
    public $data = [
            'password' => '',
            'password_confirmation' => '',
        ];
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('password')
                    ->label('Password Baru')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('password_confirmation')
                    ->live(),

                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->live(),
            ])
            ->statePath('data')
            ->model(Auth::user());
    }



    public function save(): void
    {
        $validated = $this->form->getState();
        if ($validated['password'] !== $validated['password_confirmation']) {
            Notification::make()
                ->title('Error')
                ->body('Password dan konfirmasi password harus sama.')
                ->danger()
                ->send(); // ✅ Gunakan `Notification::make()` untuk menampilkan error
            return;
        }
        User::find(1)->update([
            'password' => Hash::make($validated['password']),
        ]);

        Notification::make()
            ->title('Berhasil')
            ->body('Password berhasil diperbarui.')
            ->success()
            ->send(); // ✅ Notifikasi sukses
    }
}
