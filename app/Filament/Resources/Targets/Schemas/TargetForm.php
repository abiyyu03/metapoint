<?php

namespace App\Filament\Resources\Targets\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Issue;
use App\Models\Organization;
use App\Models\Province;
use App\Models\Title;
use App\Models\Village;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TargetForm
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
                Select::make('organization_id')
                    ->options(Organization::query()->pluck('name', 'id'))
                    ->label('Asal Kelompok'),
                Select::make('title_id')
                    ->options(Title::query()->pluck('name', 'id'))
                    ->label('Jabatan'),
                Textarea::make('address')
                    ->columnSpanFull(),
                Select::make('village_id')
                    ->searchable()
                    ->options(Village::query()->pluck('name', 'id'))
                    ->label('Desa/Kelurahan')
                    ->required(),
                Select::make('district_id')
                    ->searchable()
                    ->options(District::query()->pluck('name', 'id'))
                    ->label('Kecamatan')
                    ->searchable()
                    ->required(),
                Select::make('city_id')
                    ->searchable()
                    ->options(City::query()->pluck('name', 'id'))
                    ->label('Kota/Kabupaten')
                    ->required(),
                Select::make('province_id')
                    ->searchable()
                    ->options(Province::query()->pluck('name', 'id'))
                    ->label('Provinsi')
                    ->required(),
                Select::make('country_id')
                    ->searchable()
                    ->options(Country::query()->pluck('name', 'id'))
                    ->label('Negara Asal')
                    ->required(),
                Select::make('issue_id')
                    ->searchable()
                    ->options(Issue::query()->pluck('name', 'id'))
                    ->label('Isu')
                    ->required(),
                TextInput::make('lat')
                    ->label('Latitude')
                    ->required()
                    ->numeric(),
                TextInput::make('lng')
                    ->label('Longitude')
                    ->required()
                    ->numeric(),
            ]);
    }
}
