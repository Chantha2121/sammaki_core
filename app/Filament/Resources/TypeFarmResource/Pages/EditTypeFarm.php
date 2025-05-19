<?php

namespace App\Filament\Resources\TypeFarmResource\Pages;

use App\Filament\Resources\TypeFarmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeFarm extends EditRecord
{
    protected static string $resource = TypeFarmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
