<?php

namespace App\Filament\Resources\FundraisingTargets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FundraisingTargetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('target_id')
                    ->required()
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('unit')
                    ->required(),
                TextInput::make('amount_unit')
                    ->required(),
                TextInput::make('method_id')
                    ->required()
                    ->numeric(),
                TextInput::make('method_option_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
