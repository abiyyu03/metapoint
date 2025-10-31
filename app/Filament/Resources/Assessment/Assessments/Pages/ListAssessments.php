<?php

namespace App\Filament\Resources\Assessment\Assessments\Pages;

use App\Filament\Resources\Assessment\Assessments\AssessmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssessments extends ListRecords
{
    protected static string $resource = AssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
