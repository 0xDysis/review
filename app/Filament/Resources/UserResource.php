<?php
// app/Filament/Resources/UserResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn as TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Select;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Other fields...
                Select::make('role')
                    ->options([
                        'user' => 'User',
                        'moderator' => 'Moderator',
                        'admin' => 'Admin',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Other columns...
            TextColumn::make('name'),
            TextColumn::make('email'),
            TextColumn::make('role'),
        ])
        ->actions([
            EditAction::make()->authorize(function ($record) {
                return static::canEdit($record);
            }),
            DeleteAction::make()->authorize(function ($record) {
                return static::canDelete($record);
            }),
        ]);
}

    public static function canEdit($record): bool
{
    // Get the currently authenticated user
    $user = auth()->user();

    // Only allow admins to edit users
    return $user->role === 'admin';
}

public static function canDelete($record): bool
{
    // Get the currently authenticated user
    $user = auth()->user();

    // Only allow admins to delete users
    return $user->role === 'admin';
}

    public static function getRelations(): array
    {
        return [
            // Add relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsersPage::route('/'), 
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
