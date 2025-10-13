<?php

namespace App\Filament\Resources\FundraisingAgents\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FundraisingAgentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('agent_id')
                    ->required()
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('unit')
                    ->required(),
                TextInput::make('amount_unit')
                    ->required(),
            ]);
    }
}
