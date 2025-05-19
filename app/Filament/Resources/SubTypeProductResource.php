<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubTypeProductResource\Pages;
use App\Filament\Resources\SubTypeProductResource\RelationManagers;
use App\Models\SubTypeProduct;
use App\Models\ProductType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubTypeProductResource extends Resource
{
    protected static ?string $model = SubTypeProduct::class;

    protected static ?string $navigationGroup = 'Product Type';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description_kh')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('product_type_id')
                    ->label('Type Product')
                    ->options(ProductType::pluck('description_kh', 'id'))
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description_kh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_type.description_kh')
                    ->label('Type Product')
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
            'index' => Pages\ListSubTypeProducts::route('/'),
            'create' => Pages\CreateSubTypeProduct::route('/create'),
            'edit' => Pages\EditSubTypeProduct::route('/{record}/edit'),
        ];
    }
}
