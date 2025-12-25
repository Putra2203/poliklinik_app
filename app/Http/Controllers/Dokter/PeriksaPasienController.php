<?php

namespace App\Http\Controllers\dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log; 

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);
    
        $listObat = json_decode($request->obat_json, true);
    
        // VALIDASI TAMBAHAN 1: CEK OBAT GANDA 
        $ids = array_column($listObat, 'id');
        if (count($ids) !== count(array_unique($ids))) {
            return redirect()->back()
                ->with('error', 'Terdeteksi obat ganda dalam satu resep. Silahkan hapus dan input ulang.')
                ->withInput();
        }
    
        // VALIDASI TAMBAHAN 2: CEK STOK 
        foreach ($listObat as $item) {
            $obatDB = Obat::find($item['id']);
            if (!$obatDB) {
                return redirect()->back()->with('error', "Data obat tidak ditemukan.")->withInput();
            }
            if ($obatDB->stok < $item['jumlah']) {
                return redirect()->back()
                    ->with('error', "Stok obat '{$obatDB->nama_obat}' tidak cukup. Sisa: {$obatDB->stok}")
                    ->withInput();
            }
        }
    
        // VALIDASI TAMBAHAN 3: DATABASE TRANSACTION
        DB::beginTransaction();
    
        try {
            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => now(),
                'catatan' => $request->catatan,
                'biaya_periksa' => $request->biaya_periksa + 150000,
            ]);
    
            foreach ($listObat as $item) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $item['id'],
                    'jumlah' => $item['jumlah']
                ]);
    
                Obat::where('id', $item['id'])->decrement('stok', $item['jumlah']);
            }
    
            DB::commit();
            
            return redirect()->route('periksa-pasien.index')
                ->with('success', 'Pemeriksaan berhasil disimpan.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Error Simpan Periksa: " . $e->getMessage());
    
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data. Transaksi dibatalkan.')
                ->withInput();
        }
    }
}