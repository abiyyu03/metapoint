<?php

namespace App\Filament\Resources\Assessment\AssessmentSections\Pages;

use App\Filament\Resources\Assessment\AssessmentSections\AssessmentSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentSection extends EditRecord
{
    protected static string $resource = AssessmentSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
