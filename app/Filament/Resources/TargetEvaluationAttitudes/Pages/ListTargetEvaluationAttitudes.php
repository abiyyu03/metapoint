<?php

namespace App\Filament\Resources\TargetEvaluationAttitudes\Pages;

use App\Filament\Resources\TargetEvaluationAttitudes\TargetEvaluationAttitudeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTargetEvaluationAttitudes extends ListRecords
{
    protected static string $resource = TargetEvaluationAttitudeResource::class;
    protected static ?string $breadcrumb = 'List';
    protected static ?string $title = 'Klasifikasi Target';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            // ->label('New Klasifikasi'),
        ];
    }
}
