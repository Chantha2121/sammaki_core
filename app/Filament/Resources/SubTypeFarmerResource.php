<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubTypeFarmerResource\Pages;
use App\Filament\Resources\SubTypeFarmerResource\RelationManagers;
use App\Models\SubTypeFarmer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\TypeFarm;

class SubTypeFarmerResource extends Resource
{
    protected static ?string $model = SubTypeFarmer::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?string $navigationGroup = 'Type Farmer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description_kh')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type_farmer_id')
                    ->label('Type Farmer')
                    ->options(TypeFarm::pluck('description_kh', 'id'))
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
                Tables\Columns\TextColumn::make('type_farmer.description_kh')
                    ->label('Type Farmer')
                    ->searchable()
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
            'index' => Pages\ListSubTypeFarmers::route('/'),
            'create' => Pages\CreateSubTypeFarmer::route('/create'),
            'edit' => Pages\EditSubTypeFarmer::route('/{record}/edit'),
        ];
    }
}
