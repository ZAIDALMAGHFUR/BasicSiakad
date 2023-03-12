<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramStudy::create([
            'nama_prody' => 'Teknik Informatika',
            'kode_prody' => '001',
            'jurusan_id' => '001',
        ]);
    }
}
