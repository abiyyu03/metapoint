<?php

namespace App\Filament\Pages;

use App\Models\Target;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Wizard as ComponentsWizard;
use Filament\Schemas\Components\Wizard\Step as WizardStep;

class AssessmentAgent extends Page implements HasForms
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.assessment-agent';

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
                // STEP 1: PILIH TARGET
                WizardStep::make('Data Target')
                    ->description('Pilih target yang akan dinilai')
                    ->schema([
                        Select::make('target_id')
                            ->label('Pilih Target')
                            ->options(Target::pluck('fullname', 'id'))
                            ->searchable()
                            ->required(),
                    ]),

                // STEP 2: AM-I (4 pertanyaan choice 0-2)
                WizardStep::make('AM-I')
                    ->description('Asesmen Mandiri I (skala 0-2)')
                    ->schema([
                        Radio::make('am_i_q1')
                            ->label('1. Seberapa kuat hubungan antara penggalang dan target sebelum proses penggalangan dimulai?')
                            ->options([
                                0 => '0 = Rendah',
                                1 => '1 = Cukup',
                                2 => '2 = Tinggi',
                            ])
                            ->required(),

                        Radio::make('am_i_q2')
                            ->label('2. Seberapa sering penggalang berinteraksi dengan target?')
                            ->options([
                                0 => '0 = Jarang',
                                1 => '1 = Kadang-kadang',
                                2 => '2 = Sering',
                            ])
                            ->required(),

                        Radio::make('am_i_q3')
                            ->label('3. Seberapa besar pengaruh penggalang terhadap target dalam keputusan sehari-hari?')
                            ->options([
                                0 => '0 = Tidak Berpengaruh',
                                1 => '1 = Cukup Berpengaruh',
                                2 => '2 = Sangat Berpengaruh',
                            ])
                            ->required(),

                        Radio::make('am_i_q4')
                            ->label('4. Sejauh mana target mempercayai penggalang dalam komunikasi mereka?')
                            ->options([
                                0 => '0 = Kurang Percaya',
                                1 => '1 = Cukup Percaya',
                                2 => '2 = Sangat Percaya',
                            ])
                            ->required(),
                    ]),

                // STEP 3: AM-II (essay / uraian singkat)
                WizardStep::make('AM-II')
                    ->description('Asesmen Mandiri II — uraian singkat')
                    ->schema([
                        Textarea::make('am_ii_plan')
                            ->label('1. Apa saja rencana yang telah disusun dalam proses penggalangan?')
                            ->rows(4),

                        Textarea::make('am_ii_steps')
                            ->label('2. Apa saja tahapan yang telah direncanakan dalam melakukan penggalangan?')
                            ->rows(4),

                        Textarea::make('am_ii_constraints')
                            ->label('3. Apa saja kendala yang dialami dalam proses penggalangan?')
                            ->rows(4),

                        Textarea::make('am_ii_cost')
                            ->label('4. Estimasi pengeluaran untuk target penggalangan (Rp)')
                            ->rows(2),
                    ]),

                // STEP 4: Profil Kepribadian (10 soal Ya/Tidak)
                WizardStep::make('Profil Kepribadian')
                    ->description('Profil target — Ya / Tidak')
                    ->schema([
                        Radio::make('personality_q1')->label('Target terlihat pendiam')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q2')->label('Target terlihat ramah, suka bergaul')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q3')->label('Target cenderung suka mencari-cari kekurangan orang lain')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q4')->label('Target cenderung mudah percaya pada orang lain')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q5')->label('Target terlihat cenderung malas')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q6')->label('Target melakukan pekerjaan dengan teliti')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q7')->label('Target memiliki sedikit minat terhadap seni')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q8')->label('Target memiliki imajinasi yang aktif')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q9')->label('Target santai, mampu menangani stres dengan baik')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('personality_q10')->label('Target mudah merasa gugup')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                    ]),

                // STEP 5: Kebutuhan (A-D)
                WizardStep::make('Kebutuhan')
                    ->description('Kebutuhan: Fisiologis, Rasa Aman, Hubungan Sosial, Kehormatan')
                    ->schema([
                        // A. Fisiologis
                        Radio::make('need_food')->label('Uang makan target tercukupi')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_insurance')->label('Target memiliki asuransi kesehatan/jiwa / BPJS aktif')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_basic')->label('Target terpenuhi sandang-pangan-tempat tinggal')->options([1 => 'Ya', 0 => 'Tidak'])->required(),

                        // B. Rasa Aman
                        Radio::make('need_security')->label('Target merasa terjamin keamanannya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_financial_security')->label('Target merasa terjamin kebutuhan finansialnya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_legal')->label('Target merasa mendapatkan perlindungan hukum')->options([1 => 'Ya', 0 => 'Tidak'])->required(),

                        // C. Hubungan Sosial
                        Radio::make('need_social_friends')->label('Target mendapatkan dukungan sosial dari teman dekat')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_social_family')->label('Target mendapatkan dukungan sosial dari keluarga')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_social_neighbor')->label('Target mendapatkan dukungan sosial dari tetangga')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_social_colleague')->label('Target mendapatkan dukungan sosial dari kolega kerja')->options([1 => 'Ya', 0 => 'Tidak'])->required(),

                        // D. Kehormatan
                        Radio::make('need_reputation_home')->label('Target memiliki reputasi baik di lingkungan tempat tinggal')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_reputation_work')->label('Target memiliki reputasi baik di lingkungan kerja / sosial')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_confidence')->label('Target memiliki kepercayaan diri dan bangga akan kemampuannya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                        Radio::make('need_feeling_important')->label('Target merasa dirinya penting dalam lingkungan sosialnya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
                    ]),

                // STEP 6: Emosi terhadap Negara (10 soal skala 0-2)
                WizardStep::make('Emosi terhadap Negara')
                    ->description('Skala 0-2 untuk berbagai pertanyaan emosi/komitmen terhadap negara')
                    ->schema([
                        Radio::make('emotion_q1')->label('1. Seberapa jauh target merasa tertindas oleh pemerintah?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q2')->label('2. Seberapa jauh target merasa terancam oleh pemerintah?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q3')->label('3. Seberapa jauh target merasa kesal terhadap pemerintah?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q4')->label('4. Seberapa jauh target merasa marah terhadap pemerintah?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q5')->label('5. Seberapa jauh target merasa kecewa terhadap pemerintah?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q6')->label('6. Seberapa jauh target merasa senang terhadap negara?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q7')->label('7. Seberapa jauh target merasa bangga terhadap negara?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q8')->label('8. Seberapa jauh target merasa antusias terhadap negara?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q9')->label('9. Seberapa jauh target memiliki ketertarikan terhadap negara?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                        Radio::make('emotion_q10')->label('10. Seberapa jauh target merasa dirinya berkomitmen terhadap negara?')->options([0 => '0', 1 => '1', 2 => '2'])->required(),
                    ]),

                // STEP 7: Keterbacaan
                WizardStep::make('Keterbacaan')
                    ->description('Feedback tentang keterbacaan instrumen')
                    ->schema([
                        Radio::make('readability_instr')->label('1. Seberapa mudah dipahami instruksi dalam alat ukur ini?')->options([0 => '0 = Mudah', 1 => '1 = Sedikit Sulit', 2 => '2 = Sangat Sulit'])->required(),
                        Textarea::make('readability_instr_note')->label('Jika terdapat kesulitan, jelaskan bagian instruksi yang sulit dipahami')->rows(3),
                        Radio::make('readability_questions')->label('2. Seberapa mudah dipahami pertanyaan dalam alat ukur ini?')->options([0 => '0 = Mudah', 1 => '1 = Sedikit Sulit', 2 => '2 = Sangat Sulit'])->required(),
                        Textarea::make('readability_questions_note')->label('Jika terdapat kesulitan, jelaskan bagian pertanyaan yang sulit dipahami')->rows(3),
                    ]),

                // STEP 8: Review & Submit
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
