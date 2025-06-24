<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItineraryResource\Pages;
use App\Filament\Resources\ItineraryResource\RelationManagers;
use App\Models\Itinerary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItineraryResource extends Resource
{
    protected static ?string $model = Itinerary::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Admin Zone';

    public static function getNavigationSort(): ?int
    {
        return 4;
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\TextInput::make('day')
                ->label('Hari ke-')
                ->placeholder('Input Hari ke-')
                ->required(),

                forms\Components\TextInput::make('activity')
                ->label('Aktivitas')
                ->placeholder('Input Aktivitas')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('day'),
                tables\Columns\TextColumn::make('activity')->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItineraries::route('/'),
            'create' => Pages\CreateItinerary::route('/create'),
            'edit' => Pages\EditItinerary::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['activity'];
    }

    public static function getTitleAttribute(): string
    {
        return 'activity';
    }

}
