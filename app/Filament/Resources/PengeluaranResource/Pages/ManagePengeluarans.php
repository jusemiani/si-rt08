<?php

namespace App\Filament\Resources\PengeluaranResource\Pages;

use App\Filament\Resources\PengeluaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePengeluarans extends ManageRecords
{
    protected static string $resource = PengeluaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
