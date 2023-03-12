<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'is_mahasiswa' => true,
        ]);

        Mahasiswa::create([
            'nim' => '1234567890',
            'nama_lengkap' => 'mahasiswa',
            'email' => 'tes@gmail.com',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Jalan',
            'telepon' => '081234567890',
            'photo' => 'default.jpg',
            'program_study_id' => '1',
            'user_id' => '3',
        ]);
    }
}