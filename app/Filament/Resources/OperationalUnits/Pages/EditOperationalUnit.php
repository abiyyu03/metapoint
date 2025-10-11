<?php

namespace App\Filament\Resources\OperationalUnits\Pages;

use App\Filament\Resources\OperationalUnits\OperationalUnitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditOperationalUnit extends EditRecord
{
    protected static string $resource = OperationalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
