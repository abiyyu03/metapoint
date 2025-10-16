<?php

namespace App\Filament\Resources\Agents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AgentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('age')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('gender')
                    ->options(['L' => 'L', 'P' => 'P'])
                    ->required(),
                TextInput::make('organization_id')
                    ->numeric(),
                TextInput::make('title_id')
                    ->numeric(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('village_id')
                    ->required()
                    ->numeric(),
                TextInput::make('district_id')
                    ->required()
                    ->numeric(),
                TextInput::make('city_id')
                    ->required()
                    ->numeric(),
                TextInput::make('province_id')
                    ->required()
                    ->numeric(),
                TextInput::make('country_id')
                    ->required()
                    ->numeric(),
                TextInput::make('lat')
                    ->required()
                    ->numeric(),
                TextInput::make('lng')
                    ->required()
                    ->numeric(),
                TextInput::make('operational_unit_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
