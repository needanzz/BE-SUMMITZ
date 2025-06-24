<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Admin Zone';

    public static function getNavigationSort(): ?int
    {
        return 7;
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

                forms\Components\DatePicker::make('departure_date')
                ->label('Tanggal Keberangkatan')
                ->placeholder('Input Tanggal Keberangkatan')
                ->required(),

                forms\Components\TextInput::make('quota')
                ->label('Kuota')
                ->placeholder('Input Kuota')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('trip_id'),
                tables\Columns\TextColumn::make('departure_date'),
                tables\Columns\TextColumn::make('quota'),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
