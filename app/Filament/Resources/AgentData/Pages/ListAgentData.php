<?php

namespace App\Filament\Resources\AgentData\Pages;

use App\Filament\Resources\AgentData\AgentDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgentData extends ListRecords
{
    protected static string $resource = AgentDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
