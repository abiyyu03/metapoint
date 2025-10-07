<?php

namespace App\Filament\Resources\FundraisingTargets\Pages;

use App\Filament\Resources\FundraisingTargets\FundraisingTargetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFundraisingTargets extends ListRecords
{
    protected static string $resource = FundraisingTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
