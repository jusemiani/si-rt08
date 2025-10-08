<?php

namespace App\Filament\Resources\PengeluaranResource\Pages;

use App\Filament\Exports\PengeluaranExporter;
use App\Filament\Resources\PengeluaranResource;
use App\Models\Pengeluaran;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePengeluarans extends ManageRecords
{
    protected static string $resource = PengeluaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(PengeluaranExporter::class)
                ->label('Ekspor Pengeluaran'),
        ];
    }
}
