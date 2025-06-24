<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvinceResource\Pages;
use App\Filament\Resources\ProvinceResource\RelationManagers;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProvinceResource extends Resource
{
    protected static ?string $model = Province::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Admin Zone';

    public static function getNavigationSort(): ?int
    {
        return 1;
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\TextInput::make('province_name')
                ->label('Nama Provinsi')
                ->placeholder('Input Nama Provinsi')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('province_name')->searchable()
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
            'index' => Pages\ListProvinces::route('/'),
            'create' => Pages\CreateProvince::route('/create'),
            'edit' => Pages\EditProvince::route('/{record}/edit'),
        ];
    }
}
