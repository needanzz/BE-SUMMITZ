<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MountainResource\Pages;
use App\Filament\Resources\MountainResource\RelationManagers;
use App\Models\Mountain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MountainResource extends Resource
{
    protected static ?string $model = Mountain::class;

    protected static ?string $navigationIcon = 'heroicon-o-chevron-up';

    protected static ?string $navigationGroup = 'Admin Zone';

    public static function getNavigationSort(): ?int
    {
        return 2;
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\Select::make('province_id')
                ->label('Nama Provinsi')
                ->relationship('province', 'province_name')
                ->required(),

                forms\Components\TextInput::make('mountain_name')
                ->label('Nama Gunung')
                ->placeholder('Input Nama Gunung')
                ->required(),

                forms\Components\TextInput::make('description')
                ->label('Deskripsi')
                ->placeholder('Tambahkan Deskripsi')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('province.id')->searchable(),
                tables\Columns\TextColumn::make('mountain_name')->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMountains::route('/'),
            'create' => Pages\CreateMountain::route('/create'),
            'edit' => Pages\EditMountain::route('/{record}/edit'),
        ];
    }
}
