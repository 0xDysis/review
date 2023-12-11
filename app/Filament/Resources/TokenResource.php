<?php
// app/Filament/Resources/TokenResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TokenResource\Pages;
use Laravel\Passport\Token;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn as TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Select;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextColumn::make('id')->disabled(),
                TextColumn::make('user_id')->disabled(),
                Select::make('revoked')
                    ->options([
                        '0' => 'Active',
                        '1' => 'Revoked',
                    ])
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                
                TextColumn::make('created_at')->sortable(),
                
            ])
            ->actions([
                DeleteAction::make()->authorize(function ($record) {
                    return static::canDelete($record);
                }),
            ]);
    }

    public static function canDelete($record): bool
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Only allow admins to delete tokens
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
            'index' => Pages\ListTokens::route('/'), 
        ];
    }
}



