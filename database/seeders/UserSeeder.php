<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Podría estar interesante utilizar variables de entorno para los datos del usuario administrador
        // Por simplificar lo he escrito directamente aquí ademas también para poder visualizarlo en mi repositorio GitHub

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.es',
            'password' => bcrypt('admin')
        ]);
    }
}
