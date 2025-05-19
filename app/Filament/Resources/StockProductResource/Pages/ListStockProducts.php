<?php

namespace App\Filament\Resources\StockProductResource\Pages;

use App\Filament\Resources\StockProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockProducts extends ListRecords
{
    protected static string $resource = StockProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
