<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStats;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home'; // Icon di sidebar
    protected static string $view = 'filament.pages.dashboard'; // Menggunakan Blade custom
    protected static ?string $title = 'Dashboard'; // Judul halaman
    protected static ?int $navigationSort = 1; // Urutan menu di sidebar

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardStats::class, // ✅ Tambahkan widget statistik
        ];
    }
}
