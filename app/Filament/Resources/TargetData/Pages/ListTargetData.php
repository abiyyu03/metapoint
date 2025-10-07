<?php

namespace App\Filament\Resources\TargetData\Pages;

use App\Filament\Resources\TargetData\TargetDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTargetData extends ListRecords
{
    protected static string $resource = TargetDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
