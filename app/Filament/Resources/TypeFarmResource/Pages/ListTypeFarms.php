<?php

namespace App\Filament\Resources\TypeFarmResource\Pages;

use App\Filament\Resources\TypeFarmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeFarms extends ListRecords
{
    protected static string $resource = TypeFarmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
