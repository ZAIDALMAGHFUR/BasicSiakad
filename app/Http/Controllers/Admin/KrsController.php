<?php

namespace App\Http\Controllers\Admin;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KrsRequest;

class KrsController extends Controller
{

    public function index()
    {
        $data_tahun_akademik = TahunAkademik::select('id', 'semester', DB::raw("CONCAT(tahun_akademik,'/') AS th_akademik"))->get();
        return view('admin.krs.index', compact('data_tahun_akademik'));
    }
    

    public function find(Request $request)
{
    $request->validate([
        'nim' => 'required',
        'tahun_akademik_id' => 'required'
    ]);

    $mhs = Mahasiswa::where('nim', $request->nim)->first();
    if(is_null($mhs)) {
        return redirect()->back()->with([
            'message' => 'mahasiswa belum terdaftar !',
            'alert-type' => 'info'
        ]);
    }

    $select_krs = Krs::where('nim', $request->nim)
                ->where('tahun_akademik_id', $request->tahun_akademik_id)
                ->join('mata_kuliah', 'krs.mata_kuliah_id', '=', 'mata_kuliah.id')
                ->select('krs.id', 'mata_kuliah.nama_mata_kuliah', 'mata_kuliah.kode_mata_kuliah', 'mata_kuliah.sks')
                ->get();

    if(count($select_krs) == 0) {
        return redirect()->back()->with([
            'message' => 'mahasiswa belum terdaftar pada tahun yang dipilih !',
            'alert-type' => 'info'
        ]);
    }

    $tahun_akademik = TahunAkademik::findOrFail($request->tahun_akademik_id);
    $data_krs = [
        'nim' => $request->nim,
        'tahun_akademik_id' => $request->tahun_akademik_id,
        'nama_lengkap' => $mhs->nama_lengkap,
        'tahun_akademik' => $tahun_akademik->tahun_akademik,
        'semester' => $tahun_akademik->semester,
        'prody' => $mhs->program_study->nama_prody,
        'select_krs' => $select_krs
    ];

    return view('admin.krs.show', compact('data_krs'));
}



    public function create($nim, $tahun_akademik_id)
    {
        $data_mata_kuliah = MataKuliah::get(['nama_mata_kuliah','id']);
        $tahun_akademik = TahunAkademik::find($tahun_akademik_id);

        return view('admin.krs.create', compact('nim','tahun_akademik', 'data_mata_kuliah'));
    }


    public function store(KrsRequest $request)
    {
        Krs::create($request->validated() + ['nilai' => 0]);

        return redirect()->route('krs.index')->with([
            'message' => 'berhasi di buat !',
            'alert-type' => 'success'
        ]);


    }


    public function edit(Krs $krs)
    {
        $data_mata_kuliah = MataKuliah::get(['nama_mata_kuliah','id']);

        return view('krs.edit', compact('krs', 'data_mata_kuliah'));
    }


    public function update(KrsRequest $request, Krs $krs)
    {
        $krs->update($request->validated() + ['nilai' => 0]);

        return redirect()->route('krs.index')->with([
            'message' => 'berhasil di ganti !',
            'alert-type' => 'info'
        ]);
    }


    public function destroy(Krs $krs)
    {
        $krs->delete();

        return redirect()->back()->with([
            'message' => 'berhasi di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
