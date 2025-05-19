<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OurProductResource\Pages;
use App\Models\OurProduct;
use App\Models\MeatType;
use App\Models\VegetableType;
use App\Models\FruitType;
use App\Models\ProductType;
use App\Models\SubTypeProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


class OurProductResource extends Resource
{
    protected static ?string $model = OurProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(100),

            Forms\Components\FileUpload::make('image')
                ->label('Product Image')
                ->image()
                ->imageEditor() // Enable cropping, rotating, etc.
                ->directory('video_pic') // Save to storage/app/public/video_pic
                ->disk('public') // Use public disk (accessible via /storage)
                ->visibility('public') // File is publicly viewable
                ->getUploadedFileNameForStorageUsing(fn ($file) => $file->hashName()) // Save with a unique name
                ->required(fn ($record) => $record === null) // Only required when creating a new record
                ->enableDownload() // Allow users to download the file
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->maxSize(2048), // 2MB max

            Forms\Components\Textarea::make('product_description')
                ->required()
                ->maxLength(500),

            Forms\Components\TextInput::make('price')
                ->required()
                ->prefix('៛'),

            Select::make('product_type_id')
                ->label('Product Type')
                ->relationship('typeProduct', 'description_kh')
                ->searchable()
                ->preload()
                ->live() // This makes the field update in real-time
                ->required()
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    $set('sub_type_product_id', null); // Reset sub_type when type changes
                }),
            
            Select::make('sub_type_product_id')
                ->label('Sub Type')
                ->options(function (Forms\Get $get) {
                    $typeId = $get('product_type_id'); // Corrected key to match the product type field
                    if (!$typeId) {
                        return [];
                    }
                    return SubTypeProduct::where('product_type_id', $typeId)
                        ->pluck('description_kh', 'id');
                })
                ->searchable()
                ->preload()
                ->required(),

            // Forms\Components\Select::make('product_type_id')
            //     ->label('Product Type')
            //     ->options(ProductType::pluck('description_kh', 'id')->toArray())
            //     ->searchable()
            //     ->required(),

            // Forms\Components\Select::make('sub_type_product_id')
            //     ->label('Sub Type Product')
            //     ->options(SubTypeProduct::pluck('description_kh', 'id')->toArray())
            //     ->searchable()
            //     ->required(),
        ]);
}

    


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
                    ->sortable(),

                Tables\Columns\TextColumn::make('productType.description_kh')
                    ->label('Product Type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subTypeProduct.description_kh')
                    ->label('Sub Product Type')
                    ->sortable()
                    ->searchable(),

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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOurProducts::route('/'),
            'create' => Pages\CreateOurProduct::route('/create'),
            'edit' => Pages\EditOurProduct::route('/{record}/edit'),
        ];
    }
}