<?php

namespace App\Filament\Resources\Directorate34s\Pages;

use App\Filament\Resources\Directorate34s\Directorate34Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDirectorate34 extends EditRecord
{
    protected static string $resource = Directorate34Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
