<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class PeminjamanPerBulanChart extends ChartWidget
{
    protected static ?string $heading = 'Peminjaman per Bulan';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '278px';
    protected function getData(): array
    {
        $data = \App\Models\Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $labels = [];
        $values = [];

        foreach (range(1, 12) as $bulan) {
            $labels[] = date('M', mktime(0, 0, 0, $bulan, 1));
            $values[] = $data[$bulan] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole(['Administrator', 'Bendahara', 'Ketua RT']);
    }
}
