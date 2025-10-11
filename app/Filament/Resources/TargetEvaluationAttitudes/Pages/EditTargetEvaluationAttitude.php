<?php

namespace App\Filament\Resources\TargetEvaluationAttitudes\Pages;

use App\Filament\Resources\TargetEvaluationAttitudes\TargetEvaluationAttitudeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTargetEvaluationAttitude extends EditRecord
{
    protected static string $resource = TargetEvaluationAttitudeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
