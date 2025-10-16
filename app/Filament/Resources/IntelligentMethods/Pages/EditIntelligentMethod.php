<?php

namespace App\Filament\Resources\IntelligentMethods\Pages;

use App\Filament\Resources\IntelligentMethods\IntelligentMethodResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditIntelligentMethod extends EditRecord
{
    protected static string $resource = IntelligentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
