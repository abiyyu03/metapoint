<?php

namespace Database\Seeders;

use App\Models\Assessment\QuestionVariable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AssessmentQuestionVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('question_variables')->truncate();

        $data = [
            ["id" => 1, "dimension" => "Kepribadian", "name" => "Extravertness"],
            ["id" => 2, "dimension" => "Kepribadian", "name" => "Agreebleness"],
            ["id" => 3, "dimension" => "Kepribadian", "name" => "Conscientiousness"],
            ["id" => 4, "dimension" => "Kepribadian", "name" => "Openness"],
            ["id" => 5, "dimension" => "Kepribadian", "name" => "Neuroticism"],
            ["id" => 6, "dimension" => "Kebutuhan", "name" => "Kebutuhan Fisiologis"],
            ["id" => 7, "dimension" => "Kebutuhan", "name" => "Kebutuhan Keamanaan"],
            ["id" => 8, "dimension" => "Kebutuhan", "name" => "Kebutuhan Hubungan Sosial"],
            ["id" => 9, "dimension" => "Kebutuhan", "name" => "Kebutuhan akan Kehormatan"],
            ["id" => 10, "dimension" => "Kebutuhan", "name" => "Emosi Positif terhadap Negara"],
            ["id" => 11, "dimension" => "Kebutuhan", "name" => "Emosi Negatif terhadap Negara"],
            ["id" => 12, "dimension" => "Ideologi", "name" => "Agama"],
            ["id" => 13, "dimension" => "Ideologi", "name" => "NKRI"],
            ["id" => 14, "dimension" => "Ideologi", "name" => "Kekerasan"],
            ["id" => 15, "dimension" => "Ideologi", "name" => "Aksi Radikal"],
            ["id" => 16, "dimension" => "Ideologi", "name" => "Kepercayaan terhadap Pemerintah"],
            ["id" => 17, "dimension" => "Jejaring Sosial", "name" => "Relasi Interpersonal"],
            ["id" => 18, "dimension" => "Jejaring Sosial", "name" => "Sentralitas Peran Target Penggalangan"],
            ["id" => 19, "dimension" => "Jejaring Sosial", "name" => "Sikap Target Penggalangan"],
            ["id" => 20, "dimension" => "-", "name" => "Indikator Kesediaan Bekerjasama"],
            ["id" => 21, "dimension" => "-", "name" => "Performa Target Penggalangan"],
            ["id" => 22, "dimension" => "-", "name" => "Progres Penggalangan"],
            ["id" => 23, "dimension" => "-", "name" => "Kesulitan Dalam Penggalangan"],
            ["id" => 24, "dimension" => "Evaluasi Alat Ukur", "name" => "Evaluasi Alat Ukur"],
        ];

        QuestionVariable::insert($data);
    }
}
