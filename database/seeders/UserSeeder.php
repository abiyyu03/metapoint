<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::insert([
            [
                "id" => 1,
                'name' => "Super Administrator",
                'email' => "super_administrator@metapoint.id",
                'password' => Hash::make("123123123"),
                'operational_unit_id' => 6,
                'role_id' => 1,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                "id" => 2,
                'name' => "Operator Timsus 1",
                'email' => "operator_timsus1@metapoint.id",
                'password' => Hash::make("123123123"),
                'operational_unit_id' => 5,
                'role_id' => 2,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                "id" => 3,
                'name' => "Operator Direktorat 32",
                'email' => "operator_dir32@metapoint.id",
                'password' => Hash::make("123123123"),
                'operational_unit_id' => 1,
                'role_id' => 2,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                "id" => 4,
                'name' => "Agent 1",
                'email' => "agent1@metapoint.id",
                'password' => Hash::make("123123123"),
                'operational_unit_id' => 6,
                'role_id' => 3,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
