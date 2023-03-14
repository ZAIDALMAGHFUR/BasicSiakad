<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $user = User::create([
            'name' => $row['nama_lengkap'],
            'email' => $row['email'],
            'password' => bcrypt($row['tanggal_lahir']),
            'role_id' => 3
        ]);

        return new Mahasiswa([
            'nama_lengkap' => $row['nama_lengkap'],
            'nim' => $row['nim'],
            'alamat' => $row['alamat'],
            'email' => $row['email'],
            'telepon' => $row['telepon'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'program_study_id' => $row['program_study_id'],
            'photo' => $row['photo'],
            'user_id' => $user->id             
        ]);
    }
    
}