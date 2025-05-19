<?php

namespace App\Filament\Resources\SubTypeFarmerResource\Pages;

use App\Filament\Resources\SubTypeFarmerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubTypeFarmer extends EditRecord
{
    protected static string $resource = SubTypeFarmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
