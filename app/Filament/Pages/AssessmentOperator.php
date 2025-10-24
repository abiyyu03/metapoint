<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Schemas\Components\Wizard as ComponentsWizard;
use Filament\Schemas\Components\Wizard\Step as WizardStep;
use App\Models\Assessment\Assessment;

class AssessmentOperator extends Page
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.assessment-operator';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocument;
    protected static string|UnitEnum|null $navigationGroup = 'Assessment';

    protected function getFormSchema(): array
    {
        $assesments = Assessment::with('sections.questions.answers')
            ->orderBy('id')
            ->get();

        $steps = [];

        foreach ($assesments as $assesment) {
            $sections = [];

            foreach ($assesment->sections->sortBy('order') as $section) {
                $fields = [];

                foreach ($section->questions as $question) {
                    if ($question->type === 'choice') {
                        $options = $question->answers
                            ->sortBy('order')
                            ->pluck('label', 'id')
                            ->toArray();

                        $fields[] = Radio::make("question_{$question->id}")
                            ->label($question->value)
                            ->options($options)
                            ->required()
                            ->columns(2);
                    } else {
                        $fields[] = Textarea::make("question_{$question->id}")
                            ->label($question->value)
                            ->rows(3)
                            ->required(false);
                    }
                }

                $sections[] = Section::make($section->name)
                    ->collapsible()
                    ->collapsed()
                    ->schema($fields);
            }

            $steps[] = WizardStep::make($assesment->name)
                ->description($assesment->description)
                ->schema($sections);
        }

        return [
            ComponentsWizard::make($steps)
                ->submitAction(
                    Action::make('submit')
                        ->label('Kirim Asesmen')
                        ->submit('form')
                ),
        ];
        // return [
        //     ComponentsWizard::make([
        //         // STEP 1: PILIH TARGET DAN AGEN
        //         WizardStep::make('Pilih Target dan Agen')
        //             ->description('Target yang dinilai dan agennya.')
        //             ->schema([
        //                 Select::make('target_id')
        //                     ->label('Pilih Target')
        //                     ->options(Target::pluck('fullname', 'id'))
        //                     ->searchable()
        //                     ->required(),
        //                 Select::make('agent_id')
        //                     ->label('Pilih Agen')
        //                     ->options(Agent::pluck('fullname', 'id'))
        //                     ->searchable()
        //                     ->required(),
        //             ]),

        //         // STEP 2: Asesmen Penggalangan
        //         WizardStep::make('Assesmen Penggalangan')
        //             ->description('IKB, PTP, AM-I, AM-II')
        //             ->schema([
        //                 Section::make('A. Indikator Kesediaan Bekerjasama Target Penggalangan (IKB)')
        //                     ->description('6 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_supervisor')
        //                             ->view('filament.forms.actions.role-badge-supervisor')
        //                     ])
        //                     ->schema([
        //                         Radio::make('ikb_q1')
        //                             ->label('1. Target penggalangan bersedia melakukan kontak dengan penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak',
        //                                 1 => '1 = Ya',
        //                             ])
        //                             ->required(),

        //                         Radio::make('ikb_q2')
        //                             ->label('2. Seberapa baik kualitas kontak antara target penggalangan dengan penggalang (meskipun tidak rutin)?')
        //                             ->options([
        //                                 0 => '0 = Tidak Baik',
        //                                 1 => '1 = Baik',
        //                                 2 => '2 = Sangat Baik',
        //                             ])
        //                             ->required(),

        //                         Radio::make('ikb_q3')
        //                             ->label('3. Target penggalangan bersedia memberikan informasi kepada penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak',
        //                                 1 => '1 = Ya',
        //                             ])
        //                             ->required(),

        //                         Radio::make('ikb_q4')
        //                             ->label('4. Target penggalangan bersedia menerima arahan atau narasi dari penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak',
        //                                 1 => '1 = Ya',
        //                             ])
        //                             ->required(),
        //                         Radio::make('ikb_q5')
        //                             ->label('5. Target penggalangan bersedia mengikuti program yang ditetapkan oleh penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak',
        //                                 1 => '1 = Ya',
        //                             ])
        //                             ->required(),
        //                         Radio::make('ikb_q6')
        //                             ->label('6. Secara keseluruhan, apakah target penggalangan bersedia bekerjasama dengan penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak',
        //                                 1 => '1 = Ya',
        //                             ])
        //                             ->required(),
        //                     ]),
        //                 Section::make('B. Performa Target Penggalangan (PTP)')
        //                     ->description('3 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_supervisor')
        //                             ->view('filament.forms.actions.role-badge-supervisor')
        //                     ])
        //                     ->schema([
        //                         Radio::make('ptp_1')
        //                             ->label('1. Seberapa baik kualitas kontak antara target penggalangan dengan penggalang (meskipun tidak rutin)?')
        //                             ->options([
        //                                 0 => '0 = Tidak Pernah',
        //                                 1 => '1 = Jarang',
        //                                 2 => '2 = Sering',
        //                             ])
        //                             ->required(),
        //                         Radio::make('ptp_2')
        //                             ->label('2. Seberapa bersedia target penggalangan mengikuti arahan dan instruksi dalam melaksanakan tugas-tugas dari penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak Baik',
        //                                 1 => '1 = Baik',
        //                                 2 => '2 = Sangat Baik',
        //                             ])
        //                             ->required(),
        //                         Radio::make('ptp_3')
        //                             ->label('3. Seberapa konsisten target penggalangan dalam bekerjasama dengan penggalang?')
        //                             ->options([
        //                                 0 => '0 = Tidak Konsisten',
        //                                 1 => '1 = Konsisten',
        //                                 2 => '2 = Sangat Konsisten',
        //                             ])
        //                             ->required(),
        //                     ]),
        //                 Section::make('C. Asesmen Mandiri I (AM-I)')
        //                     ->description('4 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_penggalang')
        //                             ->view('filament.forms.actions.role-badge-penggalang')
        //                     ])
        //                     ->schema([
        //                         Radio::make('am_i_q1')
        //                             ->label('1. Seberapa kuat hubungan antara penggalang dan target sebelum proses penggalangan dimulai?')
        //                             ->options([
        //                                 0 => '0 = Rendah',
        //                                 1 => '1 = Cukup',
        //                                 2 => '2 = Tinggi',
        //                             ])
        //                             ->required(),

        //                         Radio::make('am_i_q2')
        //                             ->label('2. Seberapa sering penggalang berinteraksi dengan target?')
        //                             ->options([
        //                                 0 => '0 = Jarang',
        //                                 1 => '1 = Kadang-kadang',
        //                                 2 => '2 = Sering',
        //                             ])
        //                             ->required(),

        //                         Radio::make('am_i_q3')
        //                             ->label('3. Seberapa besar pengaruh penggalang terhadap target dalam keputusan sehari-hari?')
        //                             ->options([
        //                                 0 => '0 = Tidak Berpengaruh',
        //                                 1 => '1 = Cukup Berpengaruh',
        //                                 2 => '2 = Sangat Berpengaruh',
        //                             ])
        //                             ->required(),

        //                         Radio::make('am_i_q4')
        //                             ->label('4. Sejauh mana target mempercayai penggalang dalam komunikasi mereka?')
        //                             ->options([
        //                                 0 => '0 = Kurang Percaya',
        //                                 1 => '1 = Cukup Percaya',
        //                                 2 => '2 = Sangat Percaya',
        //                             ])
        //                             ->required(),
        //                     ]),
        //                 Section::make('D. Asesmen Mandiri II (AM-II)')
        //                     ->description('4 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_penggalang')
        //                             ->view('filament.forms.actions.role-badge-penggalang')
        //                     ])
        //                     ->schema([
        //                         Textarea::make('am_ii_q1')
        //                             ->label('1. Apa saja rencana yang telah disusun dalam proses penggalangan?')
        //                             ->rows(4),
        //                         Textarea::make('am_ii_q2')
        //                             ->label('2. Apa saja tahapan yang telah direncanakan dalam melakukan penggalangan?')
        //                             ->rows(4),
        //                         Textarea::make('am_ii_q3')
        //                             ->label('3. Apa saja kendala yang dialami dalam proses penggalangan?')
        //                             ->rows(4),
        //                         Textarea::make('am_ii_q4')
        //                             ->label('4. Estimasi pengeluaran untuk target penggalangan (Rp)')
        //                             ->rows(2),
        //                     ]),
        //             ]),

        //         // STEP 3: Profiling Target Penggalangan
        //         WizardStep::make('Profiling Target Penggalangan')
        //             ->description('Kepribadian, Kebutuhan, Narasi, Jejaring Sosial')
        //             ->schema([
        //                 Section::make('A. Kepribadian')
        //                     ->description('10 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_penggalang')
        //                             ->view('filament.forms.actions.role-badge-penggalang')
        //                     ])
        //                     ->schema([
        //                         Radio::make('personality_q1')->label('1. Target terlihat pendiam')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q2')->label('2. Target terlihat ramah, suka bergaul')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q3')->label('3. Target cenderung suka mencari-cari kekurangan orang lain')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q4')->label('4. Target cenderung mudah percaya pada orang lain')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q5')->label('5. Target terlihat cenderung malas')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q6')->label('6. Target melakukan pekerjaan dengan teliti')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q7')->label('7. Target memiliki sedikit minat terhadap seni')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q8')->label('8. Target memiliki imajinasi yang aktif')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q9')->label('9. Target santai, mampu menangani stres dengan baik')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('personality_q10')->label('10. Target mudah merasa gugup')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                     ]),

        //                 Section::make('B. Kebutuhan & Emosi terhadap Negara')
        //                     ->description('14 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_Penggalang')
        //                             ->view('filament.forms.actions.role-badge-Penggalang')
        //                     ])
        //                     ->schema([
        //                         // A. Fisiologis
        //                         Radio::make('fisiologis_q1')->label('1. Uang makan target tercukupi')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('fisiologis_q2')->label('2. Target memiliki asuransi kesehatan/jiwa / BPJS aktif')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('fisiologis_q3')->label('3. Target terpenuhi sandang-pangan-tempat tinggal')->options([1 => 'Ya', 0 => 'Tidak'])->required(),

        //                         // B. Rasa Aman
        //                         Radio::make('safety_q1')->label('1. Target merasa terjamin keamanannya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('safety_q2')->label('2. Target merasa terjamin kebutuhan finansialnya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('safety_q3')->label('3. Target merasa mendapatkan perlindungan hukum')->options([1 => 'Ya', 0 => 'Tidak'])->required(),

        //                         // C. Hubungan Sosial
        //                         Radio::make('social_q1')->label('1. Target mendapatkan dukungan sosial dari teman dekat')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('social_q2')->label('2. Target mendapatkan dukungan sosial dari keluarga')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('social_q3')->label('3. Target mendapatkan dukungan sosial dari tetangga')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('social_q4')->label('4. Target mendapatkan dukungan sosial dari kolega kerja')->options([1 => 'Ya', 0 => 'Tidak'])->required(),

        //                         // D. Kehormatan
        //                         Radio::make('dignity_q1')->label('1. Target memiliki reputasi baik di lingkungan tempat tinggal')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('dignity_q2')->label('2. Target memiliki reputasi baik di lingkungan kerja / sosial')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('dignity_q3')->label('3. Target memiliki kepercayaan diri dan bangga akan kemampuannya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                         Radio::make('dignity_q4')->label('4. Target merasa dirinya penting dalam lingkungan sosialnya')->options([1 => 'Ya', 0 => 'Tidak'])->required(),
        //                     ]),

        //                 Section::make('C. Narasi')
        //                     ->description('8 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_supervisor')
        //                             ->view('filament.forms.actions.role-badge-supervisor')
        //                     ])
        //                     ->schema([
        //                         // Narasi Ideologi
        //                         Textarea::make('narasi_ideologi_q1')->label('1. Bagaimana kepercayaan individu tentang peran agama dalam politik?')->rows(3),
        //                         Textarea::make('narasi_ideologi_q2')->label('2. Bagaimana kepercayaan individu tentang legitimasi NKRI??')->rows(3),
        //                         Textarea::make('narasi_ideologi_q3')->label('3. Bagaimana kepercayaan individu tentang penggunaan kekerasan dalam mencapai tujuan?')->rows(3),

        //                         // Narasi Aksi Radikal
        //                         Radio::make('narasi_aksi_radikal_q1')
        //                             ->label('1. Target penggalangan cenderung bersedia melakukan pelanggaran hukum (di luar arahan penggalang) ?')
        //                             ->options(
        //                                 [
        //                                     0 => 'Tidak',
        //                                     1 => 'Ya'
        //                                 ]
        //                             )
        //                             ->required(),

        //                         Radio::make('narasi_aksi_radikal_q2')
        //                             ->label('2. Untuk mencapai tujuan politik, target penggalangan cenderung bersedia melakukan kekerasan (di luar arahan penggalang)?')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),

        //                         Radio::make('narasi_aksi_radikal_q3')
        //                             ->label('3. Target penggalangan bersedia melawan polisi (di luar arahan penggalang)?')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),

        //                         // Narasi Kepercayaan Pemerintah
        //                         Radio::make('narasi_kepercayaan_pemerintah_q1')
        //                             ->label('1. Target penggalangan puas terhadap kinerja pemerintah?')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),
        //                         Radio::make('narasi_kepercayaan_pemerintah_q1')
        //                             ->label('2. Target penggalangan puas terhadap kebijakan pemerintah?')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),
        //                     ]),

        //                 Section::make('D. Jejaring Sosial')
        //                     ->description('12 Pertanyaan')
        //                     ->collapsible()
        //                     ->collapsed()
        //                     ->columns(2)
        //                     ->afterHeader([
        //                         ViewAction::make('role_supervisor')
        //                             ->view('filament.forms.actions.role-badge-supervisor')
        //                     ])
        //                     ->schema([
        //                         // A. Relasi Interpersonal
        //                         Radio::make('narasi_relasi_interpersonal_q1')
        //                             ->label('1. Seberapa dekat secara emosional hubungan penggalang dengan target penggalangan?')
        //                             ->options([
        //                                 0 => 'Tidak Dekat Sama Sekali',
        //                                 1 => 'Cukup Dekat',
        //                                 2 => 'Sangat Dekat',
        //                             ])
        //                             ->required(),
        //                         Radio::make('narasi_relasi_interpersonal_q2')
        //                             ->label('2. Seberapa percaya target penggalang terhadap penggalang?')
        //                             ->options([
        //                                 0 => 'Tidak Percaya Sama Sekali',
        //                                 1 => 'Cukup Percaya',
        //                                 2 => 'Sangat Percaya',
        //                             ])
        //                             ->required(),
        //                         Radio::make('narasi_relasi_interpersonal_q3')
        //                             ->label('3. Seberapa tergantung secara finansial target penggalang terhadap penggalang?')
        //                             ->options([
        //                                 0 => 'Tidak Tergantung Sama Sekali',
        //                                 1 => 'Cukup Tergantung',
        //                                 2 => 'Sangat Tergantung',
        //                             ])
        //                             ->required(),
        //                         Radio::make('narasi_relasi_interpersonal_q4')
        //                             ->label('4. Seberapa tergantung secara sosial/emosional target penggalang terhadap penggalang?')
        //                             ->options([
        //                                 0 => 'Tidak Tergantung Sama Sekali',
        //                                 1 => 'Cukup Tergantung',
        //                                 2 => 'Sangat Tergantung',
        //                             ])
        //                             ->required(),

        //                         // B. Sentralitas Peran Target Penggalangan
        //                         Radio::make('sentralitas_peran_target_penggalangan_q1')
        //                             ->label('1. Seberapa dekat secara emosional target penggalangan dengan entitas yang disasar?')
        //                             ->options([
        //                                 0 => 'Tidak Dekat Sama Sekali',
        //                                 1 => 'Cukup Dekat',
        //                                 2 => 'Sangat Dekat',
        //                             ])
        //                             ->required(),
        //                         Radio::make('sentralitas_peran_target_penggalangan_q2')
        //                             ->label('2. Seberapa jauh akses yang dipunyai target penggalangan dengan entitas yang disasar?')
        //                             ->options([
        //                                 0 => 'Tidak Ada Akses Sama Sekali',
        //                                 1 => 'Terdapat Akses',
        //                                 2 => 'Akses Sepenuhnya',
        //                             ])
        //                             ->required(),
        //                         Radio::make('sentralitas_peran_target_penggalangan_q3')
        //                             ->label('3. Seberapa tergantung secara finansial target penggalangan terhadap entitas yang disasar?')
        //                             ->options([
        //                                 0 => 'Tidak Tergantung Sama Sekali',
        //                                 1 => 'Cukup Tergantung',
        //                                 2 => 'Sangat Tergantung',
        //                             ])
        //                             ->required(),
        //                         Radio::make('sentralitas_peran_target_penggalangan_q4')
        //                             ->label('4. Seberapa tergantung secara non-finansial target penggalangan terhadap entitas yang disasar?')
        //                             ->options([
        //                                 0 => 'Tidak Tergantung Sama Sekali',
        //                                 1 => 'Cukup Tergantung',
        //                                 2 => 'Sangat Tergantung',
        //                             ])
        //                             ->required(),
        //                         Radio::make('sentralitas_peran_target_penggalangan_q5')
        //                             ->label('5. Apakah target penggalangan bekerja dalam tim?')
        //                             ->options([
        //                                 0 => 'Sendiri',
        //                                 1 => 'Dalam Tim',
        //                             ])
        //                             ->required(),

        //                         // C. Sikap Target Penggalangan
        //                         Radio::make('sikap_target_penggalangan_q1')
        //                             ->label('1. Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta bantuan finansial')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),
        //                         Radio::make('sikap_target_penggalangan_q2')
        //                             ->label('2. Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta saran ketika menghadapi masalah')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),
        //                         Radio::make('sikap_target_penggalangan_q3')
        //                             ->label('3. Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta pendapat dalam mengambil keputusan penting')
        //                             ->options([
        //                                 0 => 'Tidak',
        //                                 1 => 'Ya'
        //                             ])
        //                             ->required(),
        //                     ]),
        //             ]),

        //         // STEP 4: Keterbacaan
        //         WizardStep::make('Keterbacaan Alat Ukur')
        //             ->description('Feedback instrumen alat ukur')
        //             ->schema([
        //                 Radio::make('readability_q1')->label('1. Seberapa mudah dipahami instruksi dalam alat ukur ini?')->options([0 => '0 = Mudah', 1 => '1 = Sedikit Sulit', 2 => '2 = Sangat Sulit'])->required(),
        //                 Textarea::make('readability_q2')->label('2. Jika terdapat kesulitan, jelaskan bagian instruksi yang sulit dipahami')->rows(3),
        //                 Radio::make('readability_q3')->label('3. Seberapa mudah dipahami pertanyaan dalam alat ukur ini?')->options([0 => '0 = Mudah', 1 => '1 = Sedikit Sulit', 2 => '2 = Sangat Sulit'])->required(),
        //                 Textarea::make('readability_q4')->label('4. Jika terdapat kesulitan, jelaskan bagian pertanyaan yang sulit dipahami')->rows(3),
        //             ]),

        //         // STEP 7: Review & Submit
        //         // WizardStep::make('Review & Submit')
        //         //     ->description('Meninjau jawaban')
        //         //     ->schema([
        //         //         Placeholder::make('preview')
        //         //             ->label('Ringkasan jawaban sementara')
        //         //             ->content('Klik Simpan Draft untuk menyimpan sementara.')
        //         //     ]),

        //     ])
        //         ->columns(1)
        //         ->skippable()
        //         ->submitAction(
        //             Action::make('save')
        //                 ->label('Kirim Asesmen Akhir')
        //                 ->submit('form') // Memanggil action form submit
        //         )
        //     // ->persistStepInQueryString()
        //     // ->afterStateUpdated(function ($state) {
        //     //     session()->put('assessment_draft', $this->form->getState());
        //     // })

        // ];
    }
}
