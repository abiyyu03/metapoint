<?php

namespace App\Filament\Resources\Directorate32s\Pages;

use App\Filament\Resources\Directorate32s\Directorate32Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDirectorate32s extends ListRecords
{
    protected static string $resource = Directorate32Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
