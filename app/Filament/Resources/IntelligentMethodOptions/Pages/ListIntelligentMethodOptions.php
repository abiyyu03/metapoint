<?php

namespace App\Filament\Resources\IntelligentMethodOptions\Pages;

use App\Filament\Resources\IntelligentMethodOptions\IntelligentMethodOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntelligentMethodOptions extends ListRecords
{
    protected static string $resource = IntelligentMethodOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->successRedirectUrl(IntelligentMethodOptionResource::getUrl('index')),
        ];
    }
}
