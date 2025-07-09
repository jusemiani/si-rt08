<?php

namespace App\Filament\Resources\DetailPeminjamanResource\Pages;

use App\Filament\Resources\DetailPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDetailPeminjamen extends ManageRecords
{
    protected static string $resource = DetailPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
