<?php

namespace App\Filament\Resources\IntelligentMethods\Pages;

use App\Filament\Resources\IntelligentMethods\IntelligentMethodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntelligentMethods extends ListRecords
{
    protected static string $resource = IntelligentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->successRedirectUrl(IntelligentMethodResource::getUrl('index')),
        ];
    }
}
