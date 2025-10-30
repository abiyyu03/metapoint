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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TargetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // --- BAGIAN DATA UTAMA ---
                Section::make('Data Utama Target')
                    ->columns(1)
                    ->schema([
                        TextInput::make('fullname')
                            ->label("Nama Lengkap")
                            ->required(),
                        TextInput::make('age')
                            ->label('Umur')
                            // ->required()
                            ->numeric()
                            ->default(0),
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                            ->required(),
                        Select::make('organization_id')
                            ->label('Asal Kelompok')
                            ->searchable()
                            ->nullable()
                            ->options(Organization::query()->pluck('name', 'id'))
                            ->createOptionForm([
                                TextInput::make('name')->label('Nama Organisasi')->required(),
                            ])
                            ->createOptionUsing(fn(array $data): int => Organization::create($data)->id),
                        Select::make('title_id')
                            ->label('Jabatan')
                            ->nullable()
                            ->options(Title::query()->pluck('name', 'id'))
                            ->createOptionForm([
                                TextInput::make('name')->label('Nama Jabatan')->required(),
                            ])
                            ->createOptionUsing(fn(array $data): int => Title::create($data)->id),
                        Select::make('issue_id')
                            ->label('Isu')
                            ->searchable()
                            ->options(Issue::query()->pluck('name', 'id'))
                            ->createOptionForm([
                                TextInput::make('name')->label('Nama Isu')->required(),
                            ])
                            ->createOptionUsing(fn(array $data): int => Issue::create($data)->id)
                            ->required(),
                    ]),

                // --- BAGIAN DATA IDENTITAS (BARU) ---
                Section::make('Data Identitas & Kontak')
                    ->columns(1)
                    ->schema([
                        TextInput::make('nik')
                            ->label('Nomor NIK')
                            ->placeholder('Contoh: 33xxxxxxxxxxxxxx')
                            ->length(16)
                            ->nullable(),
                        TextInput::make('kk_number')
                            ->label('Nomor KK')
                            ->placeholder('Contoh: 33xxxxxxxxxxxxxx')
                            ->length(16)
                            ->nullable(),
                        TextInput::make('phone_number')
                            ->label('Nomor Handphone')
                            ->tel()
                            ->nullable(),
                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->nullable(),
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->displayFormat('d/m/Y')
                            ->nullable(),
                    ]),

                // --- BAGIAN DETAIL TARGET (BARU) ---
                Section::make('Detail Profil Target')
                    ->columns(2)
                    ->schema([
                        Select::make('target_classification')
                            ->label('Klasifikasi Target')
                            ->options([
                                'pro' => 'Pro',
                                'netral' => 'Netral',
                                'kontra' => 'Kontra',
                            ])
                            ->nullable(),

                        FileUpload::make('photo_path')
                            ->label('Foto Target')
                            ->disk('public') 
                            ->directory('target-photos') 
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1') 
                            ->imageEditor()
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('antecedents')
                            ->label('Anteseden Target (Latar Belakang/Riwayat)')
                            ->columnSpanFull() 
                            ->rows(4)
                            ->nullable(),
                    ]),

                // --- BAGIAN ALAMAT & LOKASI ---
                Section::make('Data Alamat & Lokasi')
                    ->columns(2)
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat Lengkap Target')
                            ->columnSpanFull()
                            ->nullable(),
                        Select::make('country_id')
                            ->searchable()
                            ->options(Country::query()->pluck('name', 'id'))
                            ->label('Negara Asal')
                            ->required(),
                        Select::make('province_id')
                            ->searchable()
                            ->options(Province::query()->pluck('name', 'id'))
                            ->label('Provinsi')
                            ->required(),
                        Select::make('city_id')
                            ->searchable()
                            ->options(City::query()->pluck('name', 'id'))
                            ->label('Kota/Kabupaten')
                            ->required(),
                        Select::make('district_id')
                            ->options(District::query()->pluck('name', 'id'))
                            ->label('Kecamatan')
                            ->searchable()
                            ->required(),
                        Select::make('village_id')
                            ->searchable()
                            ->options(Village::query()->pluck('name', 'id'))
                            ->label('Desa/Kelurahan')
                            ->nullable(),
                        TextInput::make('lat')
                            ->label('Latitude')
                            ->required()
                            ->numeric(),
                        TextInput::make('lng')
                            ->label('Longitude')
                            ->required()
                            ->numeric(),
                    ]),
            ]);
    }
}
