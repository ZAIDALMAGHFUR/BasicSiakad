<?php

namespace App\Http\Controllers\Admin;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Models\TranskripNilai;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TranskripNilaiController extends Controller
{
    public function index()
    {
        return view('admin.transkrip_nilai.index');
    }

    private function cekNilai($nim,$mk_id,$nilaiKhs)
    {
        $tk = TranskripNilai::where('nim', $nim)->where('mata_kuliah_id', $mk_id)->first();
        if($tk != null) {   
            if($nilaiKhs < $tk->nilai) {
                $tk->update(['nim' => $nim, 'nilai' => $nilaiKhs, 'mata_kuliah_id' => $mk_id]);
            }
        } else {
            TranskripNilai::create(['nim' => $nim, 'nilai' => $nilaiKhs, 'mata_kuliah_id' => $mk_id]);
        }
    }
    

    public function find(Request $request)
    {
        $mhs = DB::selectOne("SELECT nama_lengkap,nama_prody FROM mahasiswa
                            JOIN program_studies as ps 
                            ON ps.id = mahasiswa.program_study_id
                            WHERE nim = ?", [$request->nim]);
    
        if (!$mhs) {
            return redirect()->back()->with([
                'message' => 'Data Mahasiswa Tidak Di Temukan !',
                'alert-type' => 'info'
            ]);
        }
    
        $krs = DB::select("SELECT * FROM krs WHERE nim = ?", [$request->nim]);
        foreach($krs as $k) {
            $this->cekNilai($k->nim,$k->mata_kuliah_id,$k->nilai);
        }
    
        $transkrip_nilai = DB::select("SELECT m.kode_mata_kuliah,m.nama_mata_kuliah,m.sks,t.nilai
                                        FROM transkrip_nilai AS t
                                        JOIN mata_kuliah AS m 
                                        ON m.id = t.mata_kuliah_id
                                        WHERE nim = ?", [$request->nim]);
    
        $prody = DB::selectOne("SELECT * FROM program_studies WHERE nama_prody = ?", [$mhs->nama_prody]);
    
        $data = [
            'transkrip' => $transkrip_nilai,
            'nim' => $request->nim,
            'nama_lengkap' => $mhs->nama_lengkap,
            'prody' => $prody->nama_prody
        ];
    
        return view('admin.transkrip_nilai.show', compact('data'));
    }
    
}
