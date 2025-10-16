<?php

namespace App\Filament\Resources\Issues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IssueForm
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
