<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'dosen',
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('password'),
            'is_dosen' => true,
        ]);


        Dosen::create([
            'nidn' => '1234567890',
            'nama' => 'dosen',
            'email' => 'dosen@gmail.com',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'alamat' => 'Jl. Jalan',
            'no_hp' => '081234567890',
            'foto' => 'default.jpg',
            'user_id' => '2',
            'program_study_id' => '1',

        ]);
    }
}
