<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class UserStatusPermohonanChart extends ChartWidget
{
    protected static ?string $heading = 'Status Permohonan Saya';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '278px';

    protected function getData(): array
    {
        $userId = Auth::user()->id;

        $data = \App\Models\Permohonan::where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'datasets' => [
                [
                    'label' => 'Status',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // atau 'doughnut'
    }

    public static function canView(): bool
    {
        return Auth::user()->hasRole('Warga');
    }
}
