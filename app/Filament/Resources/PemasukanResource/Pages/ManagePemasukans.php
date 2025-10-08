<?php

namespace App\Filament\Resources\PemasukanResource\Pages;

use App\Filament\Exports\PemasukanExporter;
use App\Filament\Resources\PemasukanResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePemasukans extends ManageRecords
{
    protected static string $resource = PemasukanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(PemasukanExporter::class),
        ];
    }
}
