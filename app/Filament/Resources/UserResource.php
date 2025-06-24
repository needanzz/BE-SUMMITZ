<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationGroup = 'Customer Zone';

    public static function getNavigationSort(): ?int
    {
        return 8;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('User Name')
                    ->placeholder('Enter user name')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->placeholder('Enter active email')
                    ->required()
                    ->unique(table: User::class, column: 'email', ignorable: fn ($record) => $record),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->placeholder('Enter password')
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => !empty($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_admin')
                    ->label('Role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
                // Tables\Columns\BooleanColumn::make('deleted_at')
                //     ->label('Deleted')
                //     ->sortable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         RelationManagers\BookingsRelationManager::class,
    //         RelationManagers\ReviewsRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    // }
}