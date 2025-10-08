<?php

namespace App\Filament\Exports;

use App\Models\Pengeluaran;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PengeluaranExporter extends Exporter
{
    protected static ?string $model = Pengeluaran::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID Pengeluaran'),

            ExportColumn::make('tanggal')
                ->label('Tanggal')
                ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d M Y')),

            ExportColumn::make('keperluan')
                ->label('Keperluan'),

            ExportColumn::make('jumlah')
                ->label('Jumlah (Rp)')
                ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

            ExportColumn::make('keterangan')
                ->label('Keterangan'),

            ExportColumn::make('kegiatan.nama')
                ->label('Nama Kegiatan'),

            ExportColumn::make('user.name')
                ->label('Nama Penginput'),

            ExportColumn::make('created_at')
                ->label('Dibuat Pada')
                ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d M Y H:i')),

            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada')
                ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d M Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your pengeluaran export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
