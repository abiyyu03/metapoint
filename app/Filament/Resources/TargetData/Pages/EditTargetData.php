<?php

namespace App\Filament\Resources\TargetData\Pages;

use App\Filament\Resources\TargetData\TargetDataResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTargetData extends EditRecord
{
    protected static string $resource = TargetDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
