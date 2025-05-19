<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderProductResource\Pages;
use App\Filament\Resources\OrderProductResource\RelationManagers;
use App\Models\OrderProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderProductResource extends Resource
{
    protected static ?string $model = OrderProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('product.image')
                    ->label('Product Image')
                    ->circular()
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->product->image)),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Total Amount ($)'),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Quantity'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
            'index' => Pages\ListOrderProducts::route('/'),
            'create' => Pages\CreateOrderProduct::route('/create'),
            'edit' => Pages\EditOrderProduct::route('/{record}/edit'),
        ];
    }
}
