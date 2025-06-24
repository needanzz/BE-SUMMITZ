<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\TripResource\RelationManagers;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Admin Zone';

    public static function getNavigationSort(): ?int
    {
        return 3;
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\Select::make('mountain_id')
                ->label('Input Nama Gunung')
                ->relationship('mountain', 'mountain_name')
                ->required(),

                forms\Components\TextInput::make('title')
                ->label('Nama Trip')
                ->placeholder('Input Nama Trip')
                ->required(),

                forms\Components\TextInput::make('duration_day')
                ->label('Durasi Perjalanan')
                ->placeholder('Input Durasi Perjalanan')
                ->required(),

                forms\Components\TextInput::make('price')
                ->label('Harga Trip')
                ->placeholder('Input Harga Trip')
                ->required(),

                forms\Components\FileUpload::make('main_image')
                ->image()
                ->disk('public')
                ->directory('trips')
                ->label('Gambar Trip')
                ->placeholder('Input Gambar Trip')
                ->required(),

                forms\Components\TextInput::make('description')
                ->label('Lokasi')
                ->placeholder('Input Lokasi')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('mountain.id')->searchable(),
                tables\Columns\TextColumn::make('title')->searchable(),
                tables\Columns\TextColumn::make('duration_day'),
                tables\Columns\TextColumn::make('price')->money('IDR', locale:'id'),
                tables\Columns\ImageColumn::make('main_image')->circular(),
                tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\ItinerariesRelationManager::class,
            RelationManagers\FacilitiesRelationManager::class,
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}