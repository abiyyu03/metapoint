<?php

namespace App\Filament\Resources\Assessment\Questions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('assessment_section_id')
                    ->required()
                    ->numeric(),
                Textarea::make('value')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
