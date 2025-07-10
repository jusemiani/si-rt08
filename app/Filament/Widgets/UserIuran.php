<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class UserIuran extends ChartWidget
{
    protected static ?string $heading = 'Iuran Saya per Bulan';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '278px';

    protected function getData(): array
    {
        $userId = Auth::user()->id; // jika iuran terkait user (perlu ditambahkan di model)

        $data = \App\Models\Iuran::where('status', 'dibayar')
            // ->where('user_id', $userId) // aktifkan jika iuran punya user_id
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
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
                    'label' => 'Jumlah Iuran',
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
        return Auth::user()->hasRole('User');
    }
}
