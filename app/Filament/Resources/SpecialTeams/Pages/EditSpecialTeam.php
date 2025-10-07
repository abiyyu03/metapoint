<?php

namespace App\Filament\Resources\SpecialTeams\Pages;

use App\Filament\Resources\SpecialTeams\SpecialTeamResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSpecialTeam extends EditRecord
{
    protected static string $resource = SpecialTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
