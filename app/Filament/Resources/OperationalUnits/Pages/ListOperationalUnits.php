<?php

namespace App\Filament\Resources\OperationalUnits\Pages;

use App\Filament\Resources\OperationalUnits\OperationalUnitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOperationalUnits extends ListRecords
{
    protected static string $resource = OperationalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
