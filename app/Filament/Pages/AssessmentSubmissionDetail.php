<?php

namespace App\Filament\Pages;

use App\Models\AssessmentResult\AssessmentResult;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry as ComponentsTextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Tables\Table;

class AssessmentSubmissionDetail extends Page implements HasForms
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.assessment-submission-detail';
    protected static ?string $title = 'Detail Hasil Asesmen';
    protected static ?string $slug = 'assessment-submission/detail/{record}';

    protected static bool $shouldRegisterNavigation = false;

    public AssessmentResult $record;

    public function mount(AssessmentResult $record)
    {
        $this->record = $record;

        if (! $this->record->asesmen_data) {
            $this->record->asesmen_data = $this->getDummyAsesmenData();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Download Assesment PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('downloadPdf'),
        ];
    }

    public function downloadPdf()
    {
        $filePath = 'worksheets/Worksheet IAP3-2025.pdf';

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(Storage::disk('public')->path($filePath));
        }

        Notification::make()
            ->title('Gagal mengunduh')
            ->body('File Worksheet IAP3-2025.pdf tidak ditemukan di server.')
            ->danger()
            ->send();
    }

    public function getFormSchema(): array
    {
        $asesmenData = $this->record->asesmen_data ?? $this->getDummyAsesmenData();

        return [

            // --- SECTION 1: INFORMASI DASAR (Table Vertikal Rapi) ---
            Section::make('Informasi Dasar Laporan')
                ->description('Laporan Individual Penggalangan')
                ->schema([
                    ComponentsTextEntry::make('no')->label('No:')->state($this->record->id),
                    ComponentsTextEntry::make('target_penggalangan')->label('Target Penggalangan:')->state('Target A'),
                    ComponentsTextEntry::make('penggalang')->label('Penggalang:')->state('Penggalang A'),
                    ComponentsTextEntry::make('pengambil_data')->label('Pengambil Data:')->state('Enum A'),
                    ComponentsTextEntry::make('tanggal_pengisian')->label('Tanggal Pengisian:')->state($this->record->created_at?->translatedFormat('j F Y') ?? '1 Januari 1870'),
                ])
                ->columns(2),

            // --- SECTION 2: A. ASESMEN PROSES PENGGALANGAN (Wadah Utama) ---
            Section::make('A. Asesmen Proses Penggalangan')
                ->description('Asesmen, Kendala, dan Biaya Penggalangan.')
                ->schema([
                    Fieldset::make('Proses')
                        ->schema([
                            ViewField::make('kepribadian_table')
                                ->view('filament.pages.assessment-table1', [
                                    'data' => $asesmenData,
                                ]),
                        ])
                        ->columns(1)
                        ->extraAttributes(['class' => 'w-full']),
                    Fieldset::make('Rencana, Kendala, dan Biaya')
                        ->schema([
                            ComponentsTextEntry::make('rencana_disusun')
                                ->label('Rencana yang telah Disusun')
                                ->state('Deskripsi rencana...')->columnSpanFull(),

                            ComponentsTextEntry::make('kendala')
                                ->label('Kendala')
                                ->state('Deskripsi kendala...'),

                            ComponentsTextEntry::make('rencana_kedepan')
                                ->label('Rencana ke Depan')
                                ->state('Deskripsi rencana ke depan...'),

                            ComponentsTextEntry::make('uang_dikeluarkan')
                                ->label('Uang yang telah Dikeluarkan')
                                ->state('Rp. 50.000.000') // Nominal dari data
                        ])
                        ->columns(2),
                ]),

            // --- SECTION 3: B. PROFIL TARGET PENGGALANGAN (Wadah Utama) ---
            Section::make('B. Profil Target Penggalangan')
                ->description('Tabel-tabel profil target penggalangan.')
                ->collapsible()
                ->schema([
                    Fieldset::make('Dimensi Kepribadian')
                        ->schema([
                            ViewField::make('kepribadian_table')
                                ->view('filament.pages.assessment-table2', [
                                    'data' => $this->getDummyAsesmenPersonality('Kepribadian'),
                                ]),
                        ])
                        ->columns(1)
                        ->extraAttributes(['class' => 'w-full']),

                    Fieldset::make('Dimensi Kebutuhan')
                        ->schema([
                            ViewField::make('kebutuhan_table')
                                ->view('filament.pages.assessment-table2', [
                                    'data' => $this->getDummyAsesmenNeeds('Kebutuhan'),
                                ]),
                        ])
                        ->columns(1)
                        ->extraAttributes(['class' => 'w-full']),

                    Fieldset::make('Dimensi Ideologi')
                        ->schema([
                            ViewField::make('ideologi_table')
                                ->view('filament.pages.assessment-table2', [
                                    'data' => $this->getDummyAsesmenIdeology('Ideologi'),
                                ]),
                        ])
                        ->columns(1)
                        ->extraAttributes(['class' => 'w-full']),

                    Fieldset::make('Dimensi Jejaring Sosial')
                        ->schema([
                            ViewField::make('jejaring_table')
                                ->view('filament.pages.assessment-table2', [
                                    'data' => $this->getDummyAsesmenSocial('Jejaring Sosial'),
                                ]),
                        ])
                        ->columns(1)
                        ->extraAttributes(['class' => 'w-full']),
                ]),
        ];
    }

    protected function getDummyAsesmenData(): array
    {
        return [
            ['indeks' => 'Indikator Kesediaan Bekerjasama', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['indeks' => 'Performa Target Penggalangan', 'nilai' => 0, 'kategori' => 'Rendah'],
            ['indeks' => 'Progres Penggalangan', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['indeks' => 'Kesulitan Dalam Penggalangan', 'nilai' => 1, 'kategori' => 'Tinggi'],
        ];
    }

    protected function getDummyAsesmenPersonality($dimension): array
    {
        return [
            ['dimensi' => $dimension, 'variabel' => 'Extrovertness', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Agreebleness', 'nilai' => 0, 'kategori' => 'Rendah'],
            ['dimensi' => $dimension, 'variabel' => 'Conscientiousness', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Openness', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Neuroticism', 'nilai' => 1, 'kategori' => 'Tinggi'],
        ];
    }

    protected function getDummyAsesmenNeeds($dimension): array
    {
        return [
            ['dimensi' => $dimension, 'variabel' => 'Kebutuhan Fisiologis', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Kebutuhan Keamanan', 'nilai' => 0, 'kategori' => 'Rendah'],
            ['dimensi' => $dimension, 'variabel' => 'Kebutuhan Hubungan Sosial', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Kebutuhan akan Kehormatan', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Emosi Positif terhadap Negara', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Emosi Negatif terhadap Negara', 'nilai' => 1, 'kategori' => 'Tinggi'],
        ];
    }
    protected function getDummyAsesmenIdeology($dimension): array
    {
        return [
            ['dimensi' => $dimension, 'variabel' => 'Agama', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'NKRI', 'nilai' => 0, 'kategori' => 'Rendah'],
            ['dimensi' => $dimension, 'variabel' => 'Kekerasan', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Aksi Radikal', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Kepercayaan terhadap Pemerintah', 'nilai' => 1, 'kategori' => 'Tinggi'],
        ];
    }
    protected function getDummyAsesmenSocial($dimension): array
    {
        return [
            ['dimensi' => $dimension, 'variabel' => 'Relasi Interpersonal', 'nilai' => 1, 'kategori' => 'Tinggi'],
            ['dimensi' => $dimension, 'variabel' => 'Sentralitas Peran Target Penggalangan', 'nilai' => 0, 'kategori' => 'Rendah'],
            ['dimensi' => $dimension, 'variabel' => 'Sikap Target Penggalangan', 'nilai' => 1, 'kategori' => 'Tinggi'],
        ];
    }
}
