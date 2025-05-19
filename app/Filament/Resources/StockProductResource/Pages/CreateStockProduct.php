<?php

namespace App\Filament\Resources\StockProductResource\Pages;

use App\Filament\Resources\StockProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStockProduct extends CreateRecord
{
    protected static string $resource = StockProductResource::class;
}
