<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks agar truncate tidak error
        Schema::disableForeignKeyConstraints();

        DB::table('question_answers')->truncate();
        DB::table('answers')->truncate();
        DB::table('questions')->truncate();
        DB::table('assessment_sections')->truncate();
        DB::table('assessments')->truncate();

        Schema::enableForeignKeyConstraints();

        // ===================================
        // BAGIAN I - ASSESSMENT PENGGALANGAN
        // ===================================
        $assessment1Id = DB::table('assessments')->insertGetId([
            'name' => 'Bagian I - Assessment Penggalangan',
            'description' => 'Mengukur indikator kesediaan dan performa target penggalangan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sections1 = [
            ['name' => 'A. Indikator Kesediaan Bekerjasama Target Penggalangan (IKB)', 'order' => 1, 'description' => '6 Pertanyaan'],
            ['name' => 'B. Performa Target Penggalangan (PTP)', 'order' => 2, 'description' => '3 Pertanyaan'],
            ['name' => 'C. Assessment Mandiri I (AM-I)', 'order' => 3, 'description' => '4 Pertanyaan'],
            ['name' => 'D. Assessment Mandiri II (AM-II)', 'order' => 4, 'description' => '4 Pertanyaan'],
        ];

        foreach ($sections1 as $section) {
            $sectionId = DB::table('assessment_sections')->insertGetId([
                'assessment_id' => $assessment1Id,
                'name' => $section['name'],
                'description' => $section['description'],
                'order' => $section['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $questions = match ($section['name']) {
                'A. Indikator Kesediaan Bekerjasama Target Penggalangan (IKB)' => [
                    ['value' => 'Target penggalangan bersedia melakukan kontak dengan penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Seberapa baik kualitas kontak antara target penggalangan dengan penggalang (meskipun tidak rutin)?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Baik', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Baik', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Baik', 'value' => 2],
                    ]],
                    ['value' => 'Target penggalangan bersedia memberikan informasi kepada penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Target penggalangan bersedia menerima arahan atau narasi dari penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Target penggalangan bersedia mengikuti program yang ditetapkan oleh penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Secara keseluruhan, apakah target penggalangan bersedia bekerjasama dengan penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                ],
                'B. Performa Target Penggalangan (PTP)' => [
                    ['value' => 'Seberapa baik kualitas kontak antara target penggalangan dengan penggalang (meskipun tidak rutin)?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Pernah', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Jarang', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sering', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa bersedia target penggalangan mengikuti arahan dan instruksi dalam melaksanakan tugas-tugas dari penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Baik', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Baik', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Baik', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa konsisten target penggalangan dalam bekerjasama dengan penggalang?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Konsisten', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Konsisten', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Konsisten', 'value' => 2],
                    ]],
                ],
                'C. Assessment Mandiri I (AM-I)' => [
                    ['value' => 'Seberapa kuat hubungan antara penggalang dan target sebelum proses penggalangan dimulai?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Rendah', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Tinggi', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa sering penggalang berinteraksi dengan target?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Jarang', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Kadang-kadang', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sering', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa besar pengaruh penggalang terhadap target dalam keputusan sehari-hari?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Berpengaruh', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Berpengaruh', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Berpengaruh', 'value' => 2],
                    ]],
                    ['value' => 'Sejauh mana target mempercayai penggalang dalam komunikasi mereka?', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Kurang Percaya', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Percaya', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Percaya', 'value' => 2],
                    ]],
                ],
                'D. Assessment Mandiri II (AM-II)' => [
                    ['value' => 'Apa saja rencana yang telah disusun dalam proses penggalangan?', 'type' => 'essay'],
                    ['value' => 'Apa saja tahapan yang telah direncanakan dalam melakukan penggalangan?', 'type' => 'essay'],
                    ['value' => 'Apa saja kendala yang dialami dalam proses penggalangan?', 'type' => 'essay'],
                    ['value' => 'Estimasi pengeluaran untuk target penggalangan (Rp)', 'type' => 'essay'],
                ],
                default => [],
            };

            foreach ($questions as $q) {
                $questionId = DB::table('questions')->insertGetId([
                    'assessment_section_id' => $sectionId,
                    'value' => $q['value'],
                    'type' => $q['type'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($q['type'] === 'choice' && isset($q['options'])) {
                    foreach ($q['options'] as $order => $choice) {
                        DB::table('answers')->insert([
                            'question_id' => $questionId,
                            'label_option' => $choice['label_option'],
                            'order' => $order + 1,
                            'label' => $choice['label'],
                            'value' => $choice['value'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // ===================================
        // BAGIAN II - PROFILING TARGET PENGGALANGAN
        // ===================================
        $assessment2Id = DB::table('assessments')->insertGetId([
            'name' => 'Bagian II - Profiling Target Penggalangan',
            'description' => 'Mengukur aspek kepribadian, emosi, narasi, dan jejaring sosial target penggalangan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sections2 = [
            ['name' => 'A. Kepribadian', 'order' => 1, 'description' => '10 Pertanyaan'],
            ['name' => 'B. Kebutuhan & Emosi terhadap Negara', 'order' => 2, 'description' => '14 Pertanyaan'],
            ['name' => 'C. Narasi', 'order' => 3, 'description' => '8 Pertanyaan'],
            ['name' => 'D. Jejaring Sosial', 'order' => 4, 'description' => '12 Pertanyaan'],
        ];

        foreach ($sections2 as $section) {
            $sectionId = DB::table('assessment_sections')->insertGetId([
                'assessment_id' => $assessment2Id,
                'name' => $section['name'],
                'description' => $section['description'],
                'order' => $section['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $questions = match ($section['name']) {
                'A. Kepribadian' => [
                    ['value' => 'Target terlihat pendiam', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 1],
                    ]],
                    ['value' => 'Target terlihat ramah, suka bergaul', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target cenderung suka mencari-cari kekurangan orang lain', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 1],
                    ]],
                    ['value' => 'Target cenderung mudah percaya pada orang lain', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target terlihat cenderung malas', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 1],
                    ]],
                    ['value' => 'Target melakukan pekerjaan dengan teliti', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target memiliki sedikit minat terhadap seni', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 1],
                    ]],
                    ['value' => 'Target memiliki imajinasi yang aktif', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target santai, mampu menangani stres dengan baik', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 1],
                    ]],
                    ['value' => 'Target mudah merasa gugup', 'type' => 'choice', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                ],
                'B. Kebutuhan & Emosi terhadap Negara' => [
                    // Fisiologis
                    ['value' => 'Uang makan target tercukupi', 'type' => 'choice', 'subsection' => 'Fisiologis', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target memiliki asuransi kesehatan/jiwa / BPJS aktif', 'type' => 'choice', 'subsection' => 'Fisiologis', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target terpenuhi sandang-pangan-tempat tinggal', 'type' => 'choice', 'subsection' => 'Fisiologis', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    // Rasa Aman
                    ['value' => 'Target merasa terjamin keamanannya', 'type' => 'choice', 'subsection' => 'Rasa Aman', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target merasa terjamin kebutuhan finansialnya', 'type' => 'choice', 'subsection' => 'Rasa Aman', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target merasa mendapatkan perlindungan hukum', 'type' => 'choice', 'subsection' => 'Rasa Aman', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    // Hubungan Sosial
                    ['value' => 'Target mendapatkan dukungan sosial dari teman dekat', 'type' => 'choice', 'subsection' => 'Hubungan Sosial', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target mendapatkan dukungan sosial dari keluarga', 'type' => 'choice', 'subsection' => 'Hubungan Sosial', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target mendapatkan dukungan sosial dari tetangga', 'type' => 'choice', 'subsection' => 'Hubungan Sosial', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target mendapatkan dukungan sosial dari kolega kerja', 'type' => 'choice', 'subsection' => 'Hubungan Sosial', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    // Kehormatan
                    ['value' => 'Target memiliki reputasi baik di lingkungan tempat tinggal', 'type' => 'choice', 'subsection' => 'Kehormatan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target memiliki reputasi baik di lingkungan kerja / sosial', 'type' => 'choice', 'subsection' => 'Kehormatan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target memiliki kepercayaan diri dan bangga akan kemampuannya', 'type' => 'choice', 'subsection' => 'Kehormatan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                    ['value' => 'Target merasa dirinya penting dalam lingkungan sosialnya', 'type' => 'choice', 'subsection' => 'Kehormatan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ]],
                ],
                'C. Narasi' => [
                    // Narasi Ideologi
                    ['value' => 'Bagaimana kepercayaan individu tentang peran agama dalam politik?', 'type' => 'essay', 'subsection' => 'Narasi Ideologi'],
                    ['value' => 'Bagaimana kepercayaan individu tentang legitimasi NKRI?', 'type' => 'essay', 'subsection' => 'Narasi Ideologi'],
                    ['value' => 'Bagaimana kepercayaan individu tentang penggunaan kekerasan dalam mencapai tujuan?', 'type' => 'essay', 'subsection' => 'Narasi Ideologi'],
                    // Narasi Aksi Radikal
                    ['value' => 'Target penggalangan cenderung bersedia melakukan pelanggaran hukum (di luar arahan penggalang)?', 'type' => 'choice', 'subsection' => 'Narasi Aksi Radikal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Untuk mencapai tujuan politik, target penggalangan cenderung bersedia melakukan kekerasan (di luar arahan penggalang)?', 'type' => 'choice', 'subsection' => 'Narasi Aksi Radikal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Target penggalangan bersedia melawan polisi (di luar arahan penggalang)?', 'type' => 'choice', 'subsection' => 'Narasi Aksi Radikal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    // Narasi Kepercayaan Pemerintah
                    ['value' => 'Target penggalangan puas terhadap kinerja pemerintah?', 'type' => 'choice', 'subsection' => 'Narasi Kepercayaan Pemerintah', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Target penggalangan puas terhadap kebijakan pemerintah?', 'type' => 'choice', 'subsection' => 'Narasi Kepercayaan Pemerintah', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                ],
                'D. Jejaring Sosial' => [
                    // Relasi Interpersonal
                    ['value' => 'Seberapa dekat secara emosional hubungan penggalang dengan target penggalangan?', 'type' => 'choice', 'subsection' => 'Relasi Interpersonal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Dekat Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Dekat', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Dekat', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa percaya target penggalang terhadap penggalang?', 'type' => 'choice', 'subsection' => 'Relasi Interpersonal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Percaya Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Percaya', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Percaya', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa tergantung secara finansial target penggalang terhadap penggalang?', 'type' => 'choice', 'subsection' => 'Relasi Interpersonal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Tergantung Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Tergantung', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Tergantung', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa tergantung secara sosial/emosional target penggalang terhadap penggalang?', 'type' => 'choice', 'subsection' => 'Relasi Interpersonal', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Tergantung Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Tergantung', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Tergantung', 'value' => 2],
                    ]],
                    // Sentralitas Peran Target Penggalangan
                    ['value' => 'Seberapa dekat secara emosional target penggalangan dengan entitas yang disasar?', 'type' => 'choice', 'subsection' => 'Sentralitas Peran Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Dekat Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Dekat', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Dekat', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa jauh akses yang dipunyai target penggalangan dengan entitas yang disasar?', 'type' => 'choice', 'subsection' => 'Sentralitas Peran Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Ada Akses Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Terdapat Akses', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Akses Sepenuhnya', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa tergantung secara finansial target penggalangan terhadap entitas yang disasar?', 'type' => 'choice', 'subsection' => 'Sentralitas Peran Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Tergantung Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Tergantung', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Tergantung', 'value' => 2],
                    ]],
                    ['value' => 'Seberapa tergantung secara non-finansial target penggalangan terhadap entitas yang disasar?', 'type' => 'choice', 'subsection' => 'Sentralitas Peran Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak Tergantung Sama Sekali', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Cukup Tergantung', 'value' => 1],
                        ['label_option' => 'C', 'label' => 'Sangat Tergantung', 'value' => 2],
                    ]],
                    ['value' => 'Apakah target penggalangan bekerja dalam tim?', 'type' => 'choice', 'subsection' => 'Sentralitas Peran Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Sendiri', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Dalam Tim', 'value' => 1],
                    ]],
                    // Sikap Target Penggalangan
                    ['value' => 'Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta bantuan finansial?', 'type' => 'choice', 'subsection' => 'Sikap Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta saran ketika menghadapi masalah?', 'type' => 'choice', 'subsection' => 'Sikap Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                    ['value' => 'Apakah target penggalangan menunjukkan rasa percaya terhadap penggalang dalam hal meminta pendapat dalam mengambil keputusan penting?', 'type' => 'choice', 'subsection' => 'Sikap Target Penggalangan', 'options' => [
                        ['label_option' => 'A', 'label' => 'Tidak', 'value' => 0],
                        ['label_option' => 'B', 'label' => 'Ya', 'value' => 1],
                    ]],
                ],
                default => [],
            };

            foreach ($questions as $q) {
                $questionId = DB::table('questions')->insertGetId([
                    'assessment_section_id' => $sectionId,
                    'value' => $q['value'],
                    'type' => $q['type'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($q['type'] === 'choice') {
                    $choices = isset($q['options']) ? $q['options'] : [
                        ['label_option' => 'A', 'label' => 'Ya', 'value' => 1],
                        ['label_option' => 'B', 'label' => 'Tidak', 'value' => 0],
                    ];

                    foreach ($choices as $order => $choice) {
                        DB::table('answers')->insert([
                            'question_id' => $questionId,
                            'label_option' => $choice['label_option'],
                            'order' => $order + 1,
                            'label' => $choice['label'],
                            'value' => $choice['value'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // ===================================
        // BAGIAN III - KETERBACAAN ALAT UKUR
        // ===================================
        $assessment3Id = DB::table('assessments')->insertGetId([
            'name' => 'Bagian III - Keterbacaan Alat Ukur',
            'description' => 'Feedback instrumen alat ukur.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sectionId = DB::table('assessment_sections')->insertGetId([
            'assessment_id' => $assessment3Id,
            'name' => 'Keterbacaan Alat Ukur',
            'description' => '4 Pertanyaan',
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $questions = [
            ['value' => 'Seberapa mudah dipahami instruksi dalam alat ukur ini?', 'type' => 'choice', 'options' => [
                ['label_option' => 'A', 'label' => 'Mudah', 'value' => 0],
                ['label_option' => 'B', 'label' => 'Sedikit Sulit', 'value' => 1],
                ['label_option' => 'C', 'label' => 'Sangat Sulit', 'value' => 2],
            ]],
            ['value' => 'Jika terdapat kesulitan, jelaskan bagian instruksi yang sulit dipahami', 'type' => 'essay'],
            ['value' => 'Seberapa mudah dipahami pertanyaan dalam alat ukur ini?', 'type' => 'choice', 'options' => [
                ['label_option' => 'A', 'label' => 'Mudah', 'value' => 0],
                ['label_option' => 'B', 'label' => 'Sedikit Sulit', 'value' => 1],
                ['label_option' => 'C', 'label' => 'Sangat Sulit', 'value' => 2],
            ]],
            ['value' => 'Jika terdapat kesulitan, jelaskan bagian pertanyaan yang sulit dipahami', 'type' => 'essay'],
        ];

        foreach ($questions as $q) {
            $questionId = DB::table('questions')->insertGetId([
                'assessment_section_id' => $sectionId,
                'value' => $q['value'],
                'type' => $q['type'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($q['type'] === 'choice' && isset($q['options'])) {
                foreach ($q['options'] as $order => $choice) {
                    DB::table('answers')->insert([
                        'question_id' => $questionId,
                        'label_option' => $choice['label_option'],
                        'order' => $order + 1,
                        'label' => $choice['label'],
                        'value' => $choice['value'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
