<?php

namespace App\Filament\Resources\TargetEvaluationAttitudes\Pages;

use App\Filament\Resources\TargetEvaluationAttitudes\TargetEvaluationAttitudeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTargetEvaluationAttitude extends CreateRecord
{
    protected static string $resource = TargetEvaluationAttitudeResource::class;
    protected static ?string $breadcrumb = 'Create Klasifikasi Target';

}
