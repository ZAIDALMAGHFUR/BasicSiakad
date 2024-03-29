<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $adminCount = User::where('role_id', 1)->count();
        $dosenCount = User::where('role_id', 2)->count();
        $mahasiswaCount = User::where('role_id', 3)->count();

        $matkul = MataKuliah::all()->count();
        $fakultas = Jurusan::all()->count();
        
        $totalUsers = $adminCount + $dosenCount + $mahasiswaCount;
    
        return view('home', [
            'adminCount' => $adminCount,
            'dosenCount' => $dosenCount,
            'mahasiswaCount' => $mahasiswaCount,
            'totalUsers' => $totalUsers,
            'matkul' => $matkul,
            'fakultas' => $fakultas,
        ]);
    }
}
