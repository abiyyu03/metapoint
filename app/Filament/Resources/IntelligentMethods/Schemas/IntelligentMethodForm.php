<?php

namespace App\Filament\Resources\IntelligentMethods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IntelligentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }
}
