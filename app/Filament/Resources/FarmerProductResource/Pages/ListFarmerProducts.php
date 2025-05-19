<?php

namespace App\Filament\Resources\FarmerProductResource\Pages;

use App\Filament\Resources\FarmerProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFarmerProducts extends ListRecords
{
    protected static string $resource = FarmerProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
