<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController; 
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use Illuminate\Support\Facades\Route;
use App\Models\Obat;
use App\Models\Poli;
use App\Models\DaftarPoli;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $totalObat = Obat::count();
        $totalStokMenipis = Obat::where('stok', '<', 10)->count();
        
        $totalPoli = Poli::count();

        return view('admin.dashboard', compact(
            'totalObat', 
            'totalStokMenipis', 
            'totalPoli'
        ));
    })->name('admin.dashboard');
    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function(){
    Route::get('/dashboard', function(){
        $dokterId = Illuminate\Support\Facades\Auth::id();

        $pasienBelumDiperiksa = DaftarPoli::whereHas('jadwalPeriksa', function($q) use ($dokterId) {
            $q->where('id_dokter', $dokterId);
        })->doesntHave('periksas')->count();

        $pasienSudahDiperiksa = DaftarPoli::whereHas('jadwalPeriksa', function($q) use ($dokterId) {
            $q->where('id_dokter', $dokterId);
        })->has('periksas')->count();

        return view('dokter.dashboard', compact('pasienBelumDiperiksa', 'pasienSudahDiperiksa'));
    })->name('dokter.dashboard');
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);
    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
    Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');
    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
    Route::get('/daftar-poli', [PasienPoliController::class, 'get'])->name('pasien.daftar.index');
    Route::post('/daftar-poli', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');
});