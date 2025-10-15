<?php

namespace App\Filament\Resources\FundraisingAgents\Pages;

use App\Filament\Resources\FundraisingAgents\FundraisingAgentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFundraisingAgents extends ListRecords
{
    protected static string $resource = FundraisingAgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->successRedirectUrl(FundraisingAgentResource::getUrl('index')),
        ];
    }
}
