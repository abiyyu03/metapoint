<?php

namespace App\Filament\Resources\SpecialTeams\Pages;

use App\Filament\Resources\SpecialTeams\SpecialTeamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpecialTeams extends ListRecords
{
    protected static string $resource = SpecialTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
