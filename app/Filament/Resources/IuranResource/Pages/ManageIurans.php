<?php

namespace App\Filament\Resources\IuranResource\Pages;

use App\Filament\Resources\IuranResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIurans extends ManageRecords
{
    protected static string $resource = IuranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
