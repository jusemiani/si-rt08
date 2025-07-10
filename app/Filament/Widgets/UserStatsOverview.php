<?php

namespace App\Filament\Widgets;

use App\Models\Iuran;
use App\Models\JadwalRonda;
use App\Models\Peminjaman;
use App\Models\Permohonan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $userId = Auth::id();
        return [
            Stat::make('Peminjaman Saya', Peminjaman::where('user_id', $userId)->count())
                ->description('Total barang yang dipinjam')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('success'),

            Stat::make('Permohonan Saya', Permohonan::where('user_id', $userId)->count())
                ->description('Jumlah permohonan yang diajukan')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('warning'),

            Stat::make('Jadwal Ronda', JadwalRonda::where('user_id', $userId)->count())
                ->description('Jumlah jadwal ronda saya')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Iuran Dibayar', Iuran::where('status', 'dibayar')->count())
                ->description('Iuran terverifikasi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('User');
    }
}
