<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use App\Models\Response;

class ListResponses extends ListRecords
{
    protected static string $resource = ResponseResource::class;

    public static function query()
    {
        return Response::query();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}