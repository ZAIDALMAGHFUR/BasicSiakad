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

class KhsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data dari model TahunAkademik menggunakan method all()
        $data_tahun_akademik = TahunAkademik::all();
    
        // Kirim data tahun_akademik ke view "admin.khs.index"
        return view('admin.khs.index', compact('data_tahun_akademik'));
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
            'message' => 'Mahasiswa belum terdaftar !',
            'alert-type' => 'info'
        ]);
    }

    $selectKhs = Krs::select('krs.tahun_akademik_id', 'krs.mata_kuliah_id', 'mata_kuliah.nama_mata_kuliah', 'mata_kuliah.kode_mata_kuliah', 'mata_kuliah.sks', 'krs.nilai')
        ->join('mata_kuliah', 'krs.mata_kuliah_id', '=', 'mata_kuliah.id')
        ->where('krs.nim', $request->nim)
        ->where('krs.tahun_akademik_id', $request->tahun_akademik_id)
        ->get();

    if($selectKhs->isEmpty()) {
        return redirect()->back()->with([
            'message' => 'Mahasiswa belum terdaftar pada tahun yang dipilih !',
            'alert-type' => 'info'
        ]);
    }

    $data_khs = [
        'mhs_data' => $selectKhs,
        'nim' => $request->nim,
        'nama_lengkap' => $mhs->nama_lengkap,
        'prody' => $mhs->program_study->nama_prody,
        'tahun_akademik' => TahunAkademik::where('id', $request->tahun_akademik_id)->first()->tahun_akademik,
        'semester' => TahunAkademik::where('id', $request->tahun_akademik_id)->first()->semester
    ];

    return view('admin.khs.show', compact('data_khs'));
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

        
        return redirect()->route('admin.krs.index')->with([
            'message' => 'berhasi di buat !',
            'alert-type' => 'success'
        ]);
    }


    public function edit(Krs $krs)
    {
        $data_mata_kuliah = MataKuliah::get(['nama_mata_kuliah','id']);

        return view('admin.krs.edit', compact('krs', 'data_mata_kuliah'));
    }


    public function update(KrsRequest $request, Krs $krs)
    {
        $krs->update($request->validated() + ['nilai' => 0]);

        return redirect()->route('admin.krs.index')->with([
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
