<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoTutorialResource\Pages;
use App\Models\VideoTutorial;
use App\Models\SubTypeFarmer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;


class VideoTutorialResource extends Resource
{
    protected static ?string $model = VideoTutorial::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(100),
                Forms\Components\FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->imageEditor() 
                    ->directory('video_pic')
                    ->disk('public')
                    ->visibility('public')
                    ->getUploadedFileNameForStorageUsing(fn ($file) => $file->hashName())
                    ->required(fn ($record) => $record === null)
                    ->enableDownload()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048),
                
                
                Forms\Components\TextInput::make('video')
                    ->required()
                    ->maxLength(100),           
                Textarea::make('description')
                    ->required()
                    ->maxLength(500)
                    ->rows(4),
                Select::make('type_farm_id')
                    ->label('Type')
                    ->relationship('typeFarm', 'description_kh')
                    ->searchable()
                    ->preload()
                    ->live() // This makes the field update in real-time
                    ->required()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('sub_type_id', null); // Reset sub_type when type changes
                    }),
                
                Select::make('sub_type_id')
                    ->label('Sub Type')
                    ->options(function (Forms\Get $get) {
                        $typeId = $get('type_farm_id');
                        if (!$typeId) {
                            return [];
                        }
                        return SubTypeFarmer::where('type_farmer_id', $typeId)
                            ->pluck('description_kh', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('image')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->image)), // Use the `asset` helper to generate the correct URL
                Tables\Columns\TextColumn::make('video')
                    ->label('Video code'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('cropType.description_kh')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('feedingType.description_kh')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('typeFarm.description_kh')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideoTutorials::route('/'),
            'create' => Pages\CreateVideoTutorial::route('/create'),
            'edit' => Pages\EditVideoTutorial::route('/{record}/edit'),
        ];
    }
}
