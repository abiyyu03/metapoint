<?php

namespace Database\Seeders;

use App\Models\IntelligentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntelligentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IntelligentMethod::insert([
            [
                "id" => 1,
                "name" => "MICE"
            ],
            [
                "id" => 2,
                "name" => "RASCLS"
            ],
            [
                "id" => 3,
                "name" => "Other Option"
            ]
        ]);
    }
}
