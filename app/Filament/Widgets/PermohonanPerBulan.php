<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class PermohonanPerBulan extends ChartWidget
{
    protected static ?string $heading = 'Permohonan per Bulan';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '278px';
    protected function getData(): array
    {
        $data = \App\Models\Permohonan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
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
                    'label' => 'Jumlah Permohonan',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole(['Administrator', 'Bendahara', 'Ketua RT']);
    }
}
