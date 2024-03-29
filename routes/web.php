<?php

use App\Http\Controllers\Admin\MahasiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group(['middleware' => ['auth', 'OnlyAdmin']], function () {
    
    // search feature
    Route::get('mahasiswa/search', [MahasiswaController::class, 'search'])->name('mahasiswa.live_search');
    Route::get('users/search', [\App\Http\Controllers\UserController::class, 'search'])->name('users.live_search');

    //membuat export data mahasiswa dengan xl
    Route::get('users/export/', [\App\Http\Controllers\UserController::class, 'export'])->name('users.export');
    Route::get('mahasiswa/export/', [MahasiswaController::class, 'export'])->name('mahasiswa.export');

    // dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //membuat import data mahasiswa dengan xl
    Route::post('import_excel', [App\Http\Controllers\Admin\MahasiswaController::class, 'importExcel'])->name('import_excel');

    // jurusan crud
    Route::resource('jurusan', \App\Http\Controllers\Admin\JurusanController::class)->except('show');
    Route::resource('program_study', \App\Http\Controllers\Admin\ProgramStudyController::class)->except('show');
    Route::resource('mata_kuliah', \App\Http\Controllers\Admin\MataKuliahController::class)->except('show');
    Route::resource('mahasiswa', \App\Http\Controllers\Admin\MahasiswaController::class);
    // tahun akademik
    Route::resource('tahun_akademik', \App\Http\Controllers\Admin\TahunAkademikController::class);
    // krs
    Route::get('krs/create/{nim}/{tahun_akademik}', [\App\Http\Controllers\Admin\KrsController::class, 'create'])->name('krs.create');
    Route::get('krs', [\App\Http\Controllers\Admin\KrsController::class, 'index'])->name('krs.index');
    Route::post('krs', [\App\Http\Controllers\Admin\KrsController::class, 'find'])->name('krs.find');
    Route::post('krs/store', [\App\Http\Controllers\Admin\KrsController::class, 'store'])->name('krs.store');
    Route::get('krs/{krs:id}/edit', [\App\Http\Controllers\Admin\KrsController::class, 'edit'])->name('krs.edit');
    Route::put('krs/{krs:id}', [\App\Http\Controllers\Admin\KrsController::class, 'update'])->name('krs.update');
    Route::delete('krs/{krs:id}', [\App\Http\Controllers\Admin\KrsController::class, 'destroy'])->name('krs.destroy');
    // khs
    Route::get('khs', [\App\Http\Controllers\Admin\KhsController::class, 'index'])->name('khs.index');
    Route::post('khs', [\App\Http\Controllers\Admin\KhsController::class, 'find'])->name('khs.find');
    // input nilai
    Route::get('input_nilai', [\App\Http\Controllers\Admin\InputNilaiController::class, 'index'])->name('input_nilai.index');
    Route::post('input_nilai', [\App\Http\Controllers\Admin\InputNilaiController::class, 'all'])->name('input_nilai.all');
    Route::post('input_nilai/store', [\App\Http\Controllers\Admin\InputNilaiController::class, 'store'])->name('input_nilai.store');
    // transkrip nilai
    Route::get('transkrip_nilai', [\App\Http\Controllers\Admin\TranskripNilaiController::class, 'index'])->name("transkrip_nilai.index");
    Route::post('transkrip_nilai', [\App\Http\Controllers\Admin\TranskripNilaiController::class, 'find'])->name("transkrip_nilai.find");

    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::get('users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::get('users/update', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::post('users/store', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
