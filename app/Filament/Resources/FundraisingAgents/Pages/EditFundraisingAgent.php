<?php

namespace App\Filament\Resources\FundraisingAgents\Pages;

use App\Filament\Resources\FundraisingAgents\FundraisingAgentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditFundraisingAgent extends EditRecord
{
    protected static string $resource = FundraisingAgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
