<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsersPage extends ListRecords
{
    public static string $resource = UserResource::class;
}