<?php

namespace App\Filament\Resources\FundraisingTargets\Pages;

use App\Filament\Resources\FundraisingTargets\FundraisingTargetResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditFundraisingTarget extends EditRecord
{
    protected static string $resource = FundraisingTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
