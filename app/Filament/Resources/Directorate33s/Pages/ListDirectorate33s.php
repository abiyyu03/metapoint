<?php

namespace App\Filament\Resources\Directorate33s\Pages;

use App\Filament\Resources\Directorate33s\Directorate33Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDirectorate33s extends ListRecords
{
    protected static string $resource = Directorate33Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
