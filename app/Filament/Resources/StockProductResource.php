<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockProductResource\Pages;
use App\Filament\Resources\StockProductResource\RelationManagers;
use App\Models\StockProduct;
use Filament\Forms;
use App\Models\OurProduct;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockProductResource extends Resource
{
    protected static ?string $model = StockProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product name')
                    ->options(OurProduct::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product name')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('product.image')
                    ->label('Product Image')
                    ->circular()
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->product->image)),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label("Create at"),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label("Update at")
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockProducts::route('/'),
            'create' => Pages\CreateStockProduct::route('/create'),
            'edit' => Pages\EditStockProduct::route('/{record}/edit'),
        ];
    }
}
