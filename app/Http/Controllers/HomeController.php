<?php

namespace App\Http\Controllers;

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
        $adminCount = User::where('is_admin', 1)->count();
        $dosenCount = User::where('is_dosen', 1)->count();
        $mahasiswaCount = User::where('is_mahasiswa', 1)->count();
        
        $totalUsers = $adminCount + $dosenCount + $mahasiswaCount;
    
        return view('home', [
            'adminCount' => $adminCount,
            'dosenCount' => $dosenCount,
            'mahasiswaCount' => $mahasiswaCount,
            'totalUsers' => $totalUsers
        ]);
    }
}
