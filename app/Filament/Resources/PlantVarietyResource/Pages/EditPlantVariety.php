<?php

namespace App\Filament\Resources\PlantVarietyResource\Pages;

use App\Filament\Resources\PlantVarietyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlantVariety extends EditRecord
{
    protected static string $resource = PlantVarietyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
