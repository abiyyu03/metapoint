<?php

namespace App\Filament\Resources\Villages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VillageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code'),
                TextInput::make('district_id')
                    ->numeric(),
            ]);
    }
}
