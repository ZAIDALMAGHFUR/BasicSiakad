<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JurusanRequest;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = Jurusan::get();

        return view('admin.jurusan.index', compact('jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JurusanRequest $request)
    {
        // Jurusan::create($request->validated());        

        $this->validate($request, [
            'kode_jurusan' => 'required|unique:jurusan',
            'nama_jurusan' => 'required|unique:jurusan',
        ]);

        Jurusan::create([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')->with([
            'message' => 'berhasi di buat !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JurusanRequest $request, Jurusan $jurusan)
    {

        $this->validate($request, [
            'kode_jurusan' => 'required|unique:jurusan',
            'nama_jurusan' => 'required|unique:jurusan',
        ]);

        $jurusan->update([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')->with([
            'message' => 'berhasil di ganti !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->back()->with([
            'message' => 'berhasi di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
