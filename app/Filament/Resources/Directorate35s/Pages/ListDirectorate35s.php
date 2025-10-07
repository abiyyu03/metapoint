<?php

namespace App\Filament\Resources\Directorate35s\Pages;

use App\Filament\Resources\Directorate35s\Directorate35Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDirectorate35s extends ListRecords
{
    protected static string $resource = Directorate35Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
