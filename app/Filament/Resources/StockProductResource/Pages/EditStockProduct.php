<?php

namespace App\Filament\Resources\StockProductResource\Pages;

use App\Filament\Resources\StockProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockProduct extends EditRecord
{
    protected static string $resource = StockProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
