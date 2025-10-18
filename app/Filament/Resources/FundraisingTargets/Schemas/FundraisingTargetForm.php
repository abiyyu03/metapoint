<?php

namespace App\Filament\Resources\FundraisingTargets\Schemas;

use App\Models\IntelligentMethod;
use App\Models\IntelligentMethodOption;
use App\Models\Target;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FundraisingTargetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('target_id')
                    ->options(Target::query()->pluck('fullname', 'id'))
                    ->searchable()
                    ->label('Nama Target')
                    ->required(),
                Select::make('type')
                    ->label('Tipe Insentif / Dukungan')
                    ->searchable()
                    ->options([
                        'finansial' => 'Finansial (uang, bantuan dana, kompensasi)',
                        'logistik' => 'Logistik (alat, kendaraan, fasilitas, perlengkapan)',
                        'informasi' => 'Informasi (akses data, dokumen, intel)',
                        'proteksi' => 'Proteksi (perlindungan, jaminan keamanan)',
                        'keistimewaan' => 'Keistimewaan (izin khusus, akses prioritas)',
                        'pelatihan' => 'Pelatihan (training, pembinaan, peningkatan kemampuan)',
                        'relasi' => 'Relasi (dukungan jaringan, kontak, koneksi strategis)',
                        'lainnya' => 'Lainnya',
                    ])
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nama Jenis Insentif / Dukungan Baru')
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data, Select $component): string {
                        $options = $component->getOptions();
                        $options[$data['name']] = $data['name'];
                        $component->options($options);
                        return $data['name'];
                    })
                    ->required(),

                Select::make('unit')
                    ->label('Tipe Satuan / Bentuk Kuantifikasi')
                    ->searchable()
                    ->options([
                        'rupiah' => 'Rupiah (Rp)',
                        'paket' => 'Paket / Item',
                        'jam' => 'Jam',
                        'hari' => 'Hari',
                        'minggu' => 'Minggu',
                        'bulan' => 'Bulan',
                        'laporan' => 'Laporan / Informasi',
                        'aksi' => 'Aksi / Operasi',
                        'dukungan' => 'Dukungan / Bantuan',
                        'poin' => 'Poin Penilaian',
                        'lainnya' => 'Lainnya',
                    ])
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nama Satuan/unit Baru')
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data, Select $component): string {
                        $options = $component->getOptions();
                        $options[$data['name']] = $data['name'];
                        $component->options($options);
                        return $data['name'];
                    })
                    ->required(),
                TextInput::make('amount_unit')
                    ->label('Jumlah Unit')
                    ->default(1)
                    ->numeric(),
                Select::make('method_id')
                    ->label('Metode Intelijen')
                    ->options(IntelligentMethod::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
                Select::make('method_option_id')
                    ->label('Opsi Metode Intelijen')
                    ->searchable()
                    ->options(function (callable $get) {
                        $methodId = $get('method_id');

                        $methods = new IntelligentMethodOption;

                        if ($methodId && $methods != null) {
                            $methods->where('intelligent_method_id', $methodId);
                        }

                        if ($methodId == 3) {
                            $option = IntelligentMethodOption::firstOrCreate([
                                'name' => 'Opsi Lainnya',
                                'intelligent_method_id' => $methodId,
                            ]);

                            return [$option->id => $option->name];
                        }

                        return $methods->pluck('name', 'id');
                    })
                    ->required(),
            ]);
    }
}
