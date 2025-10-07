<?php

namespace App\Filament\Resources\Directorate34s\Pages;

use App\Filament\Resources\Directorate34s\Directorate34Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDirectorate34s extends ListRecords
{
    protected static string $resource = Directorate34Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
