<?php

namespace App\Filament\Resources\TripResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Forms;

class FacilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'facilities';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('item')
                ->label('Item')
                ->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item')
                    ->label('Item')
                    ->searchable(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }
}