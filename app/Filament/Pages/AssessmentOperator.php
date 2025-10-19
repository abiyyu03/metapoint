<?php

namespace App\Filament\Pages;

use App\Models\Agent;
use App\Models\Target;
use BackedEnum;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Schemas\Components\Wizard as ComponentsWizard;
use Filament\Schemas\Components\Wizard\Step as WizardStep;

class AssessmentOperator extends Page
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.assessment-operator';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocument;
    protected static string|UnitEnum|null $navigationGroup = 'Assessment';


    public ?array $data = []; // Tempat simpan sementara jawaban

    public function mount(): void
    {
        // jika ada draft di session, muat ke form
        $draft = session()->get('assessment_draft', null);
        if ($draft && is_array($draft)) {
            $this->data = $draft;
            $this->form->fill($this->data);
        } else {
            $this->form->fill();
        }
    }

    protected function getFormSchema(): array
    {
        return [
            ComponentsWizard::make([
                // STEP 1: PILIH TARGET DAN AGEN
                WizardStep::make('Data Target dan Agen')
                    ->description('Pilih target yang akan dinilai dan agen penilainya.')
                    ->schema([
                        Select::make('target_id')
                            ->label('Pilih Target')
                            ->options(Target::pluck('fullname', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('agent_id')
                            ->label('Pilih Agen')
                            ->options(Agent::pluck('fullname', 'id'))
                            ->searchable()
                            ->required(),
                    ]),

                // STEP 2: IKB (6 pertanyaan choice 0-2)
                WizardStep::make('IKB')
                    ->description('Indikator Kesediaan Bekerjasama Target Penggalangan (skala)')
                    ->schema([
                        Radio::make('am_i_q1')
                            ->label('1. Target penggalangan bersedia melakukan kontak dengan penggalang?')
                            ->options([
                                0 => '0 = Tidak',
                                1 => '1 = Ya',
                            ])
                            ->required(),

                        Radio::make('am_i_q2')
                            ->label('2. Seberapa baik kualitas kontak antara target penggalangan dengan penggalang (meskipun tidak rutin)?')
                            ->options([
                                0 => '0 = Tidak Baik',
                                1 => '1 = Baik',
                                2 => '2 = Sangat Baik',
                            ])
                            ->required(),

                        Radio::make('am_i_q3')
                            ->label('3. Target penggalangan bersedia memberikan informasi kepada penggalang?')
                            ->options([
                                0 => '0 = Tidak',
                                1 => '1 = Ya',
                            ])
                            ->required(),

                        Radio::make('am_i_q4')
                            ->label('4. Target penggalangan bersedia menerima arahan atau narasi dari penggalang?')
                            ->options([
                                0 => '0 = Tidak',
                                1 => '1 = Ya',
                            ])
                            ->required(),
                        Radio::make('am_i_q5')
                            ->label('5. Target penggalangan bersedia mengikuti program yang ditetapkan oleh penggalang?')
                            ->options([
                                0 => '0 = Tidak',
                                1 => '1 = Ya',
                            ])
                            ->required(),
                        Radio::make('am_i_q5')
                            ->label('6. Secara keseluruhan, apakah target penggalangan bersedia bekerjasama dengan penggalang?')
                            ->options([
                                0 => '0 = Tidak',
                                1 => '1 = Ya',
                            ])
                            ->required(),
                    ]),

                // STEP 3: PTP
                WizardStep::make('PTP')
                    ->description('Performa Target Penggalangan (skala)')
                    ->schema([
                        Radio::make('ptp_1')
                            ->label('1. Seberapa baik kualitas kontak antara target penggalangan dengan penggalang (meskipun tidak rutin)?')
                            ->options([
                                0 => '0 = Tidak Pernah',
                                1 => '1 = Jarang',
                                2 => '2 = Sering',
                            ])
                            ->required(),
                        Radio::make('ptp_2')
                            ->label('2. Seberapa bersedia target penggalangan mengikuti arahan dan instruksi dalam melaksanakan tugas-tugas dari penggalang?')
                            ->options([
                                0 => '0 = Tidak Baik',
                                1 => '1 = Baik',
                                2 => '2 = Sangat Baik',
                            ])
                            ->required(),
                        Radio::make('ptp_3')
                            ->label('3. Seberapa konsisten target penggalangan dalam bekerjasama dengan penggalang?')
                            ->options([
                                0 => '0 = Tidak Konsisten',
                                1 => '1 = Konsisten',
                                2 => '2 = Sangat Konsisten',
                            ])
                            ->required(),


                    ]),

                // STEP 4: Narasi
                WizardStep::make('Narasi')
                    ->description('Profil Target')
                    ->schema([
                        // Narasi Ideologi
                        Textarea::make('narasi_ideologi_q1')->label('Bagaimana kepercayaan individu tentang peran agama dalam politik?')->rows(3),
                        Textarea::make('narasi_ideologi_q2')->label('Bagaimana kepercayaan individu tentang legitimasi NKRI??')->rows(3),
                        Textarea::make('narasi_ideologi_q3')->label('Bagaimana kepercayaan individu tentang penggunaan kekerasan dalam mencapai tujuan?')->rows(3),

                        // Narasi Aksi Radikal
                        Radio::make('narasi_aksi_radikal_q1')
                            ->label('Target penggalangan cenderung bersedia melakukan pelanggaran hukum (di luar arahan penggalang) ?')
                            ->options(
                                [
                                    0 => 'Tidak',
                                    1 => 'Ya'
                                ]
                            )
                            ->required(),

                        Radio::make('narasi_aksi_radikal_q2')
                            ->label('Untuk mencapai tujuan politik, target penggalangan cenderung bersedia melakukan kekerasan (di luar arahan penggalang)?')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),

                        Radio::make('narasi_aksi_radikal_q3')
                            ->label('Target penggalangan bersedia melawan polisi (di luar arahan penggalang)?')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),

                        // Narasi Kepercayaan Pemerintah
                        Radio::make('narasi_kepercayaan_pemerintah_q1')
                            ->label('Target penggalangan puas terhadap kinerja pemerintah?')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),
                        Radio::make('narasi_kepercayaan_pemerintah_q1')
                            ->label('TTarget penggalangan puas terhadap kebijakan pemerintah?')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),

                    ]),

                // STEP 5: Jejaring Sosial
                WizardStep::make('Jejaring Sosial')
                    ->description('Profil Target')
                    ->schema([
                        // A. Relasi Interpersonal
                        Radio::make('narasi_relasi_interpersonal_q1')
                            ->label('Seberapa dekat secara emosional hubungan penggalang dengan target penggalangan?')
                            ->options([
                                0 => 'Tidak Dekat Sama Sekali',
                                1 => 'Cukup Dekat',
                                2 => 'Sangat Dekat',
                            ])
                            ->required(),
                        Radio::make('narasi_relasi_interpersonal_q2')
                            ->label('Seberapa percaya target penggalang terhadap penggalang?')
                            ->options([
                                0 => 'Tidak Percaya Sama Sekali',
                                1 => 'Cukup Percaya',
                                2 => 'Sangat Percaya',
                            ])
                            ->required(),
                        Radio::make('narasi_relasi_interpersonal_q3')
                            ->label('Seberapa tergantung secara finansial target penggalang terhadap penggalang?')
                            ->options([
                                0 => 'Tidak Tergantung Sama Sekali',
                                1 => 'Cukup Tergantung',
                                2 => 'Sangat Tergantung',
                            ])
                            ->required(),
                        Radio::make('narasi_relasi_interpersonal_q4')
                            ->label('Seberapa tergantung secara sosial/emosional target penggalang terhadap penggalang?')
                            ->options([
                                0 => 'Tidak Tergantung Sama Sekali',
                                1 => 'Cukup Tergantung',
                                2 => 'Sangat Tergantung',
                            ])
                            ->required(),

                        // B. Sentralitas Peran Target Penggalangan
                        Radio::make('sentralitas_peran_target_penggalangan_q1')
                            ->label('Seberapa dekat secara emosional target penggalangan dengan entitas yang disasar?')
                            ->options([
                                0 => 'Tidak Dekat Sama Sekali',
                                1 => 'Cukup Dekat',
                                2 => 'Sangat Dekat',
                            ])
                            ->required(),
                        Radio::make('sentralitas_peran_target_penggalangan_q2')
                            ->label('Seberapa jauh akses yang dipunyai target penggalangan dengan entitas yang disasar?')
                            ->options([
                                0 => 'Tidak Ada Akses Sama Sekali',
                                1 => 'Terdapat Akses',
                                2 => 'Akses Sepenuhnya',
                            ])
                            ->required(),
                        Radio::make('sentralitas_peran_target_penggalangan_q3')
                            ->label('Seberapa tergantung secara finansial target penggalangan terhadap entitas yang disasar?')
                            ->options([
                                0 => 'Tidak Tergantung Sama Sekali',
                                1 => 'Cukup Tergantung',
                                2 => 'Sangat Tergantung',
                            ])
                            ->required(),
                        Radio::make('sentralitas_peran_target_penggalangan_q4')
                            ->label('Seberapa tergantung secara non-finansial target penggalangan terhadap entitas yang disasar?')
                            ->options([
                                0 => 'Tidak Tergantung Sama Sekali',
                                1 => 'Cukup Tergantung',
                                2 => 'Sangat Tergantung',
                            ])
                            ->required(),
                        Radio::make('sentralitas_peran_target_penggalangan_q5')
                            ->label('Apakah target penggalangan bekerja dalam tim?')
                            ->options([
                                0 => 'Sendiri',
                                1 => 'Dalam Tim',
                            ])
                            ->required(),

                        // C. Sikap Target Penggalangan
                        Radio::make('sikap_target_penggalangan_q1')
                            ->label('Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta bantuan finansial')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),
                        Radio::make('sikap_target_penggalangan_q2')
                            ->label('Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta saran ketika menghadapi masalah')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),
                        Radio::make('sikap_target_penggalangan_q3')
                            ->label('Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta pendapat dalam mengambil keputusan penting')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya'
                            ])
                            ->required(),
                    ]),

                // STEP 6: Keterbacaan
                WizardStep::make('Keterbacaan')
                    ->description('Feedback tentang keterbacaan instrumen')
                    ->schema([
                        Radio::make('readability_instr')->label('1. Seberapa mudah dipahami instruksi dalam alat ukur ini?')->options([0 => '0 = Mudah', 1 => '1 = Sedikit Sulit', 2 => '2 = Sangat Sulit'])->required(),
                        Textarea::make('readability_instr_note')->label('Jika terdapat kesulitan, jelaskan bagian instruksi yang sulit dipahami')->rows(3),
                        Radio::make('readability_questions')->label('2. Seberapa mudah dipahami pertanyaan dalam alat ukur ini?')->options([0 => '0 = Mudah', 1 => '1 = Sedikit Sulit', 2 => '2 = Sangat Sulit'])->required(),
                        Textarea::make('readability_questions_note')->label('Jika terdapat kesulitan, jelaskan bagian pertanyaan yang sulit dipahami')->rows(3),
                    ]),

                // STEP 7: Review & Submit
                WizardStep::make('Review & Submit')
                    ->description('Tinjau jawaban sebelum menyimpan draft')
                    ->schema([
                        Placeholder::make('preview')
                            ->label('Ringkasan jawaban sementara')
                            ->content('Klik Simpan Draft untuk menyimpan sementara.')
                    ]),

            ])
                ->columns(1)
                ->skippable()
                ->submitAction('Simpan Draft')
                ->persistStepInQueryString()
                ->afterStateUpdated(function ($state) {
                    session()->put('assessment_draft', $this->form->getState());
                })

        ];
    }

    // protected function getSummaryHtml(): string
    // {
    //     $data = $this->form->getState() ?? $this->data ?? [];

    //     // ringkasan sederhana: tampilkan beberapa field penting + json untuk sisa
    //     $target = null;
    //     if (!empty($data['target_id'])) {
    //         $t = Target::find($data['target_id']);
    //         $target = $t ? e($t->fullname) : '—';
    //     }

    //     $summary = '<div style="max-height:320px;overflow:auto;padding:8px;">';
    //     $summary .= "<p><strong>Target:</strong> {$target}</p>";

    //     // contoh ringkasan AM-I
    //     if (isset($data['am_i_q1'])) {
    //         $summary .= '<p><strong>AM-I (ringkasan):</strong> ' .
    //             'Q1=' . e((string)$data['am_i_q1']) . ', ' .
    //             'Q2=' . e((string)($data['am_i_q2'] ?? '-')) . ', ' .
    //             'Q3=' . e((string)($data['am_i_q3'] ?? '-')) . ', ' .
    //             'Q4=' . e((string)($data['am_i_q4'] ?? '-')) .
    //             '</p>';
    //     }

    //     // tampilkan AM-II singkat (jika ada)
    //     if (!empty($data['am_ii_plan'])) {
    //         $summary .= '<p><strong>AM-II (rencana):</strong> ' . e(substr($data['am_ii_plan'], 0, 200)) . ((strlen($data['am_ii_plan']) > 200) ? '...' : '') . '</p>';
    //     }

    //     // sisanya: dump JSON kecil (aman untuk demo)
    //     $summary .= '<details><summary>Show raw data</summary><pre style="white-space:pre-wrap;">' . e(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . '</pre></details>';

    //     $summary .= '</div>';

    //     return $summary;
    // }

    // public function getFormActionsAlignment(): Alignment
    // {
    //     return Alignment::Right;
    // }

    public function submit()
    {
        $this->data = $this->form->getState();

        // simpan ke session (key: assessment_draft)
        session()->put('assessment_draft', $this->data);

        Notification::make()
            ->title('Draft disimpan')
            ->success()
            ->send();

        // refresh form state agar placeholder summary terupdate
        $this->form->fill($this->data);
    }
}
