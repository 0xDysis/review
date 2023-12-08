<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponseResource\Pages;
use App\Models\Response;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('content')
                    ->label('Response Content')
                    ->required(),
                // Add more fields as needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User'),
                TextColumn::make('content')
                    ->label('Response Content'),
                TextColumn::make('review.content')
                    ->label('Review Content'),
            ])
            ->actions([
                EditAction::make(),
                Action::make('Approve')
                    ->icon('heroicon-o-check')
                    ->button(fn ($record) => !$record->is_approved ? 'indigo' : '') // Only show the button if the response is not approved
                    ->action(fn ($action, $record) => static::approveResponseAction($action, $record)),
            ]);
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
            'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }

    public static function approveResponseAction($action, Response $response)
    {
        $response->update(['is_approved' => true]);

        return back()->with('success', 'Response approved successfully.');
    }
}