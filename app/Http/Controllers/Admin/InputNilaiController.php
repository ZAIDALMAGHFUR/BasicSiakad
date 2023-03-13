<?php

namespace App\Http\Controllers\Admin;

use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InputNilaiController extends Controller
{
    public function index()
    {
        $data_tahun_akademik = TahunAkademik::select('id', 'semester', DB::raw("CONCAT(tahun_akademik,'/') AS th_akademik"))->get();
        return view('admin.input_nilai.index', compact('data_tahun_akademik'));
    }
    

    public function all(Request $request)
{
    $request->validate([
        'tahun_akademik_id' => 'required',
        'kode_mata_kuliah' => 'required'
    ]);

    $mata_kuliah = MataKuliah::where('kode_mata_kuliah', $request->kode_mata_kuliah)->firstOrFail();

    $list_nilai = DB::table('krs')
                        ->join('mahasiswa', 'mahasiswa.nim', '=', 'krs.nim')
                        ->join('mata_kuliah', 'mata_kuliah.id', '=', 'krs.mata_kuliah_id')
                        ->where('krs.tahun_akademik_id', $request->tahun_akademik_id)
                        ->where('krs.mata_kuliah_id', $mata_kuliah->id)
                        ->select('krs.id', 'krs.nim', 'mahasiswa.nama_lengkap', 'krs.nilai', 'mata_kuliah.nama_mata_kuliah')
                        ->get();

    $th_akademik = TahunAkademik::findOrFail($request->tahun_akademik_id)->tahun_akademik;
    $semester = TahunAkademik::findOrFail($request->tahun_akademik_id)->semester;

    if($list_nilai->isEmpty()) {
        return redirect()->back()->with([
            'message' => "mahasiswa tidak terdaftar di tahun ajaran $th_akademik ($semester)",
            'alert-type' => 'info'
        ]);
    }

    $data = [
        'list_nilai' => $list_nilai,
        'kode_mata_kuliah' => $request->kode_mata_kuliah,
        'nama_mata_kuliah' => $mata_kuliah->nama_mata_kuliah,
        'tahun_akademik' => $th_akademik,
        'semester' => $semester,
        'sks' => $mata_kuliah->sks
    ];

    return view('admin.input_nilai.show', compact('data'));
}


    public function store(Request $request)
    {
        $ids = $request->id;
        $nilai = $request->nilai;

        foreach($ids as $key => $id) {
            $krs = Krs::find($id);
            $krs->update(['nilai' => $nilai[$key]]);
        }

        $krs = Krs::with('mata_kuliah','tahun_akademik')->find($ids[0]);
        
        return view('admin.input_nilai.daftar_nilai', compact('krs','ids'));
    }
}
