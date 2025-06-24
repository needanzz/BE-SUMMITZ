<?php

namespace App\Filament\Resources\TripResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Forms;

class ItinerariesRelationManager extends RelationManager
{
    protected static string $relationship = 'itineraries';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('day')
                ->label('Hari ke-')
                ->required(),

            Forms\Components\TextInput::make('activity')
                ->label('Kegiatan')
                ->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day')->label('Hari ke-'),
                Tables\Columns\TextColumn::make('activity')->label('Kegiatan')->searchable(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->recordSelect(
                fn (Forms\Components\Select $select) => $select
                ->options(
                    \App\Models\Itinerary::all()->pluck('activity', 'id')
                )),
                Tables\Actions\CreateAction::make(), // untuk buat itinerary baru
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }
}
