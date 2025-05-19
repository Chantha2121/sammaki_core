<?php

namespace App\Filament\Resources\OurProductResource\Pages;

use App\Filament\Resources\OurProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOurProduct extends EditRecord
{
    protected static string $resource = OurProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
