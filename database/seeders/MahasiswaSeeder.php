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
            'role_id' => 3,
        ]);
    }
}