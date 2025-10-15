<?php

namespace App\Filament\Resources\Titles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TitleForm
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
