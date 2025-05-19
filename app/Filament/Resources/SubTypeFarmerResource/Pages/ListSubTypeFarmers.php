<?php

namespace App\Filament\Resources\SubTypeFarmerResource\Pages;

use App\Filament\Resources\SubTypeFarmerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubTypeFarmers extends ListRecords
{
    protected static string $resource = SubTypeFarmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
