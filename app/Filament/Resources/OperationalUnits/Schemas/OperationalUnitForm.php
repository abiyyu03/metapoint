<?php

namespace App\Filament\Resources\OperationalUnits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OperationalUnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
