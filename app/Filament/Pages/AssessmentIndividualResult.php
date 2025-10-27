<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use UnitEnum;

class AssessmentIndividualResult extends Page
{
    protected string $view = 'filament.pages.assessment-individual-result';
    protected static string|UnitEnum|null $navigationGroup = 'Assessment';
}
