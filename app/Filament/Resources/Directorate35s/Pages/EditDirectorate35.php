<?php

namespace App\Filament\Resources\Directorate35s\Pages;

use App\Filament\Resources\Directorate35s\Directorate35Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDirectorate35 extends EditRecord
{
    protected static string $resource = Directorate35Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
