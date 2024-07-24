<?php

namespace App\Filament\Resources\PlantVarietyResource\Pages;

use App\Filament\Resources\PlantVarietyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlantVarieties extends ListRecords
{
    protected static string $resource = PlantVarietyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
