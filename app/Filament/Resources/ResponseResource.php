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
use Filament\Tables\Columns\ToggleColumn;


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
            ToggleColumn::make('is_approved')
                ->label('Approval Status'),
        ])
        ->actions([
            EditAction::make(),
        ]);
}


    public static function shouldShowApproveAction($record): bool
    {
        return !$record->is_approved; // Check the approval status of the Response model instance
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
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }

    public static function approveResponseAction($action, Response $response)
    {
        $response->update(['is_approved' => true]);

        return back()->with('success', 'Response approved successfully.');
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
