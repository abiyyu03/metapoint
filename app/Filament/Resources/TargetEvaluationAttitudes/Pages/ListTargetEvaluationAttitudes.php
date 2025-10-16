<?php

namespace App\Filament\Resources\TargetEvaluationAttitudes\Pages;

use App\Filament\Resources\TargetEvaluationAttitudes\TargetEvaluationAttitudeResource;
use App\Filament\Resources\Targets\TargetResource;
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
            CreateAction::make()
                ->successRedirectUrl(TargetEvaluationAttitudeResource::getUrl('index')),
        ];
    }
}
