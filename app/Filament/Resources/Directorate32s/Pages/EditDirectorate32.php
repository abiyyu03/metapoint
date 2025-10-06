<?php

namespace App\Filament\Resources\Directorate32s\Pages;

use App\Filament\Resources\Directorate32s\Directorate32Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDirectorate32 extends EditRecord
{
    protected static string $resource = Directorate32Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
