<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    public function get()
    {
        // Mengambil data pasien yang sedang login dengan eager loading
        $user = Auth::user();
        
        // Mengambil semua data poli
        $polis = Poli::all();
        
        // Mengambil jadwal periksa dengan eager loading dokter dan poli dokter
        $jadwal = JadwalPeriksa::with(['dokter', 'dokter.poli'])->get();
        
        // Mengambil daftar poli milik pasien yang login dengan eager loading
        $daftarPolis = DaftarPoli::with(['jadwalPeriksa.dokter.poli', 'jadwalPeriksa.dokter'])
            ->where('id_pasien', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.daftar', [
            'user' => $user,
            'polis' => $polis,
            'jadwals' => $jadwal,
            'daftarPolis' => $daftarPolis,
        ]);
    }

    public function submit(Request $request)
    {
        // Validasi data yang diinput
        $validated = $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:500',
        ]);

        // Ambil ID pasien yang sedang login
        $user = Auth::user();
        
        // Hitung nomor antrian secara otomatis berdasarkan jadwal yang dipilih
        $jumlahSudahDaftar = DaftarPoli::where('id_jadwal', $request->id_jadwal)->count();
        $noAntrian = $jumlahSudahDaftar + 1;
        
        // Simpan data pendaftaran ke database
        $daftar = DaftarPoli::create([
            'id_pasien' => $user->id,
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $noAntrian,
        ]);

        return redirect()->back()->with('message', 'Berhasil mendaftar ke poli dengan nomor antrian: ' . $noAntrian)->with('type', 'success');
    }
}