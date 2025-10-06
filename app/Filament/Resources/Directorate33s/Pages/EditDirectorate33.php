<?php

namespace App\Filament\Resources\Directorate33s\Pages;

use App\Filament\Resources\Directorate33s\Directorate33Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDirectorate33 extends EditRecord
{
    protected static string $resource = Directorate33Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
