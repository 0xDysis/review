<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;


class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Review Title')
                    ->required(),
                TextInput::make('content')
                    ->label('Review Content')
                    ->required(),
                TextInput::make('score')
                    ->label('Review Score')
                    ->required()
                    ->numeric(), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User'),
                TextColumn::make('title')
                    ->label('Review Title'),
                TextColumn::make('content')
                    ->label('Review Content'),
                TextColumn::make('score')
                    ->label('Review Score'),
                ToggleColumn::make('is_approved')
                    ->label('Approval Status'),
            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListReviews::route('/'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
    

    public static function approveReviewAction($action, Review $review)
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Review approved successfully.');
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

