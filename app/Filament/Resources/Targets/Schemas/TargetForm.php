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
                TextInput::make('fullname')
                    ->label("Nama Lengkap")
                    ->required(),
                TextInput::make('age')
                    ->label('Umur')
                    ->required()
                    ->numeric(),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                    ->required(),
                Select::make('organization_id')
                    ->searchable()
                    ->options(Organization::query()->pluck('name', 'id'))
                    ->label('Asal Kelompok'),
                Select::make('title_id')
                    ->options(Title::query()->pluck('name', 'id'))
                    ->label('Jabatan'),
                Textarea::make('address')
                    ->label('Alamat Target'),
                Select::make('village_id')
                    ->searchable()
                    ->options(Village::query()->pluck('name', 'id'))
                    ->label('Desa/Kelurahan')
                    ->required(),
                Select::make('district_id')
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
