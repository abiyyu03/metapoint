<?php

namespace App\Filament\Resources\AgentData\Pages;

use App\Filament\Resources\AgentData\AgentDataResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAgentData extends EditRecord
{
    protected static string $resource = AgentDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
