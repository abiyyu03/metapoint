<?php

namespace Database\Seeders;

use App\Models\IntelligentMethodOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntelligentMethodOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        IntelligentMethodOption::insert([
            [
                "id" => 1,
                "intelligent_method_id" => 1,
                "name" => "Money"
            ],
            [
                "id" => 2,
                "intelligent_method_id" => 1,
                "name" => "Ideology"
            ],
            [
                "id" => 3,
                "intelligent_method_id" => 1,
                "name" => "Compromy"
            ],
            [
                "id" => 4,
                "intelligent_method_id" => 1,
                "name" => "Ego"
            ],
            [
                "id" => 5,
                "intelligent_method_id" => 2,
                "name" => "Compromy"
            ],
            [
                "id" => 6,
                "intelligent_method_id" => 2,
                "name" => "Reciprocation"
            ],
            [
                "id" => 7,
                "intelligent_method_id" => 2,
                "name" => "Authority"
            ],
            [
                "id" => 8,
                "intelligent_method_id" => 2,
                "name" => "Scarcity"
            ],
            [
                "id" => 9,
                "intelligent_method_id" => 2,
                "name" => "Commitment and Consistency"
            ],
            [
                "id" => 10,
                "intelligent_method_id" => 2,
                "name" => "Liking"
            ],
            [
                "id" => 11,
                "intelligent_method_id" => 2,
                "name" => "Social Proof"
            ]
        ]);
    }
}
