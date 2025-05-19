<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmerProductResource\Pages;
use App\Filament\Resources\FarmerProductResource\RelationManagers;
use App\Models\FarmerProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FarmerProductResource extends Resource
{
    protected static ?string $model = FarmerProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Farmer';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->image)),
                Tables\Columns\TextColumn::make('product_description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type_product.description_kh')
                    ->label('Product Type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sub_type_product.description_kh')
                    ->label('Sub Product Type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('farmer.name')
                    ->label('Farmer Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFarmerProducts::route('/'),
            'create' => Pages\CreateFarmerProduct::route('/create'),
            'edit' => Pages\EditFarmerProduct::route('/{record}/edit'),
        ];
    }
}
