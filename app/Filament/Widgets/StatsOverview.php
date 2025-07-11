<?php

namespace App\Filament\Widgets;

use App\Models\Iuran;
use App\Models\Peminjaman;
use App\Models\Permohonan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Peminjaman', Peminjaman::count())
                ->description('Seluruh transaksi peminjaman')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('success'),

            Stat::make('Total Iuran', Iuran::count())
                ->description('Pembayaran iuran tercatat')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Permohonan', Permohonan::count())
                ->description('Permohonan yang diajukan warga')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('warning'),

            Stat::make('Total Pengguna', User::count())
                ->description('Seluruh pengguna sistem')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole(['Administrator', 'Bendahara', 'Ketua RT']);
    }
}
