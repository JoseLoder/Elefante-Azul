<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeWashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipe_washes')->insert([
            [
                'description' => 'Lavado básico',
                'price' => '10',
                'time' => '20',
            ],
            [
                'description' => 'Lavado completo',
                'price' => '20',
                'time' => '40',
            ],
            [
                'description' => 'Lavado premium',
                'price' => '40',
                'time' => '60',
            ]
        ]);
    }
}
