<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Customer Zone';

    public static function getNavigationSort(): ?int
    {
        return 11;
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\Select::make('payment_status')
                ->label('Status Payment')
                ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed' => 'Failed',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                tables\Columns\TextColumn::make('transaction_id')->searchable(),
                tables\Columns\TextColumn::make('booking.user.name')->searchable(),
                tables\Columns\TextColumn::make('order_id')->searchable(),
                tables\Columns\TextColumn::make('payment_status')->badge()
                ->color(fn(string $state):string=>match($state){
                    'pending' => 'warning',
                    'success' => 'success',
                    'failed' => 'dagger',
                }),
                tables\Columns\TextColumn::make('paid_at'),
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
            'index' => Pages\ListPayments::route('/'),
            // 'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
