<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function rules(): array
    {
        return [
            'nim' => function($attribute, $value, $onFailure) {
                if (Mahasiswa::where('nim', '=', $value)->exists()) {
                    $onFailure("NIM $value sudah ada");
                    // dd($value);
                }
            },
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'email' => function($attribute, $value, $onFailure) {
                if (User::where('email', $value)->exists()) {
                    $onFailure("Email $value sudah ada");
                }
            },
            'telepon' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'program_study_id' => 'required'
        ];
    }



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