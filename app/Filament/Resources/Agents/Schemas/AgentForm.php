<?php

namespace App\Filament\Resources\Agents\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\OperationalUnit;
use App\Models\Organization;
use App\Models\Province;
use App\Models\Title;
use App\Models\Village;
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
                TextInput::make('fullname')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('age')
                    ->label('Umur')
                    ->required()
                    ->numeric(),
                Select::make('gender')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                    ->label('Jenis Kelamin')
                    ->required(),
                // Select::make('organization_id')
                //     ->options(Organization::query()->pluck('name', 'id'))
                //     ->label('Kelompok/Afiliasi'),
                // Select::make('title_id')
                //     ->options(Title::query()->pluck('name', 'id'))
                //     ->label('Jabatan'),
                Select::make('operational_unit_id')
                    ->options(OperationalUnit::query()->pluck('name', 'id'))
                    ->label('Unit Operasional')
                    ->required(),
                Textarea::make('address')
                    ->label('Alamat')
                    ->required(),
                Select::make('country_id')
                    ->options(Country::query()->pluck('name', 'id'))
                    ->label('Negara')
                    ->searchable()
                    ->required(),
                Select::make('province_id')
                    ->options(Province::query()->pluck('name', 'id'))
                    ->label('Provinsi')
                    ->searchable()
                    ->required(),
                Select::make('city_id')
                    ->options(City::query()->pluck('name', 'id'))
                    ->label('Kabupaten/Kota')
                    ->searchable()
                    ->required(),
                Select::make('district_id')
                    ->options(District::query()->pluck('name', 'id'))
                    ->label('Kecamatan')
                    ->searchable()
                    ->required(),
                Select::make('village_id')
                    ->options(Village::query()->pluck('name', 'id'))
                    ->label('Kelurahan')
                    ->searchable()
                    ->required(),
                TextInput::make('lat')
                    ->label('Latitude')
                    ->required()
                    ->numeric(),
                TextInput::make('lng')
                    ->label('Longitude')
                    ->required()
                    ->numeric(),
                Select::make('targets')
                    ->columnSpanFull()
                    ->label('Target Agent')
                    ->multiple()
                    ->relationship('targets', 'fullname')
                    ->preload() // load cepat
                    ->searchable(),
            ]);
    }
}
