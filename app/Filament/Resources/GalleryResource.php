<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationGroup = 'Admin Zone';

    public static function getNavigationSort(): ?int
    {
        return 6;
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\Select::make('trip_id')
                ->label('Pilih Trip')
                ->relationship('trip', 'title')
                ->required(),

                forms\Components\FileUpload::make('image_path')
                ->label('Gambar Trip')
                ->multiple()
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('trip_id'),
                tables\Columns\ImageColumn::make('image_path')->circular(),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
