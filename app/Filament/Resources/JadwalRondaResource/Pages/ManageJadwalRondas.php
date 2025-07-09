<?php

namespace App\Filament\Resources\JadwalRondaResource\Pages;

use App\Filament\Resources\JadwalRondaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJadwalRondas extends ManageRecords
{
    protected static string $resource = JadwalRondaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
