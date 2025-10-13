<?php

namespace App\Filament\Resources\IntelligentMethodOptions\Schemas;

use App\Models\IntelligentMethod;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IntelligentMethodOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('intelligent_method_id')
                    ->searchable()
                    ->options(IntelligentMethod::query()->pluck('name', 'id'))
                    ->label('Metode Intelijen')
                    ->required(),
            ]);
    }
}
