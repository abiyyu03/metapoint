<?php

namespace App\Filament\Pages;

use App\Models\AssessmentResult\AssessmentResult;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Fieldset;

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
                    Placeholder::make('no')->label('No:')->content($this->record->id),
                    Placeholder::make('target_penggalangan')->label('Target Penggalangan:')->content('Target A'),
                    Placeholder::make('penggalang')->label('Penggalang:')->content('Penggalang A'),
                    Placeholder::make('pengambil_data')->label('Pengambil Data:')->content('Enum A'),
                    Placeholder::make('tanggal_pengisian')->label('Tanggal Pengisian:')->content($this->record->created_at?->translatedFormat('j F Y') ?? '1 Januari 1870'),
                ])
                ->columns(2),

            // --- SECTION 2: A. ASESMEN PROSES PENGGALANGAN (Wadah Utama) ---
            Section::make('A. Asesmen Proses Penggalangan')
                ->description('Asesmen, Kendala, dan Biaya Penggalangan.')
                ->collapsible()
                ->schema([

                    Fieldset::make('Tabel 1: Indeks Asesmen')
                        ->schema([
                            Repeater::make('assessment_table_1_data')
                                ->label(false)
                                ->disabled()
                                ->default(fn() => $asesmenData)
                                ->columns(5)
                                ->schema([
                                    TextInput::make('indeks')->columnSpan(3)->label('Indeks'),
                                    TextInput::make('nilai')->columnSpan(1)->label('Nilai'),
                                    TextInput::make('kategori')->columnSpan(1)->label('Kategori'),
                                ]),
                        ]),

                    Fieldset::make('Rencana, Kendala, dan Biaya')
                        ->schema([
                            Placeholder::make('rencana_disusun')
                                ->label('Rencana yang telah Disusun')
                                ->content('Deskripsi rencana...')->columnSpanFull(),

                            Placeholder::make('kendala')
                                ->label('Kendala')
                                ->content('Deskripsi kendala...'),

                            Placeholder::make('rencana_kedepan')
                                ->label('Rencana ke Depan')
                                ->content('Deskripsi rencana ke depan...'),

                            Placeholder::make('uang_dikeluarkan')
                                ->label('Uang yang telah Dikeluarkan')
                                ->content('Rp. 50.000.000') // Nominal dari data
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
                            // Isi dengan Repeater atau ViewEntry Table 1 Profil
                        ]),

                    Fieldset::make('Dimensi Kebutuhan')
                        ->schema([
                            // Isi dengan Repeater atau ViewEntry Table 2 Profil
                        ]),

                    Fieldset::make('Dimensi Ideologi')
                        ->schema([
                            // Isi dengan Repeater atau ViewEntry Table 2 Profil
                        ]),

                    Fieldset::make('Dimensi Jejaring Sosial')
                        ->schema([
                            // Isi dengan Repeater atau ViewEntry Table 2 Profil
                        ]),
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
}
