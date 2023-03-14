<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Imports\UsersImport;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\MahasiswaRequest;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data_mahasiswa = Mahasiswa::with('program_study')->paginate(5);
        // $data_mahasiswa = Mahasiswa::with('program_study')->where('status', '=', 'aktif')->paginate(5);



        return view('admin.mahasiswa.index', compact('data_mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $program_studies = ProgramStudy::get(['id', 'nama_prody']);

        return view('admin.mahasiswa.create', compact('program_studies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request)
    {
        // dd($request->all());
        if($request->validated()) {
            $photo = $request->file('photo')->store(
                'mahasiswa/photo', 'public'
            );
            
            $User = User::create(['name'=> $request->nama_lengkap, 'email' => $request->email, 'password' => bcrypt($request->tanggal_lahir), 'role_id'  =>    3]);
            
            $queri = [
                'nim' => $request->nim,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'photo' => $photo,
                'program_study_id' => $request->program_study_id,
                'user_id' => $User->id,
            ];

            $User->mahasiswa()->create($queri);

        }

        return redirect()->route('mahasiswa.index')->with([
            'message' => 'berhasi di buat !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $program_studies = ProgramStudy::get(['id', 'nama_prody']);

        return view('admin.mahasiswa.edit', compact('mahasiswa','program_studies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        if($request->validated()) {
            if($request->photo) {
                File::delete('storage/'. $mahasiswa->photo);
                $photo = $request->file('photo')->store(
                    'mahasiswa/photo', 'public'
                );
                $mahasiswa->update($request->except('photo') + ['photo' => $photo]);
            }else {
                $mahasiswa->update($request->validated());
            }
        }

        return redirect()->route('mahasiswa.index')->with([
            'message' => 'berhasil di ganti !',
            'alert-type' => 'info'
        ]);
    }


    public function importExcel (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        

        Excel::import(new UsersImport, $file);

        return redirect()->back()->with([
            'message' => 'berhasi di import !',
            'alert-type' => 'success'
        ]);
    }


    public function destroy(Mahasiswa $mahasiswa)
    {
        File::delete('storage/'. $mahasiswa->photo);
        $mahasiswa->delete();
        $user = User::where('id', $mahasiswa->user_id)->first();
        $user->delete();

        return redirect()->back()->with([
            'message' => 'berhasi di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
