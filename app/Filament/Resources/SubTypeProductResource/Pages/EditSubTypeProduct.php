<?php

namespace App\Filament\Resources\SubTypeProductResource\Pages;

use App\Filament\Resources\SubTypeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubTypeProduct extends EditRecord
{
    protected static string $resource = SubTypeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
