<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramStudyRequest;

class ProgramStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $program_studies = ProgramStudy::with('jurusan')->get();

        return view('admin.program_study.index', compact('program_studies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::get(['id', 'nama_jurusan']);

        return view('admin.program_study.create', compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgramStudyRequest $request)
    {

        $this->validate($request, [
            'kode_prody' => 'required|unique:program_studies',
            'nama_prody' => 'required|unique:program_studies',
            'jurusan_id' => 'required',
        ]);

        ProgramStudy::create([
            'kode_prody' => $request->kode_prody,
            'nama_prody' => $request->nama_prody,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('program_study.index')->with([
            'message' => 'berhasi di buat !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudy $program_study)
    {

        $jurusans = Jurusan::get(['id', 'nama_jurusan']);

        return view('admin.program_study.edit', compact('program_study','jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramStudyRequest $request, ProgramStudy $program_study)
    {
        $this->validate($request, [
            'kode_prody' => 'required|unique:program_studies',
            'nama_prody' => 'required|unique:program_studies',
            'jurusan_id' => 'required',
        ]);

        ProgramStudy::create([
            'kode_prody' => $request->kode_prody,
            'nama_prody' => $request->nama_prody,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('program_study.index')->with([
            'message' => 'berhasil di ganti !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudy $program_study)
    {
        $program_study->delete();

        return redirect()->back()->with([
            'message' => 'berhasi di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
